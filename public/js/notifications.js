document.addEventListener("DOMContentLoaded", function () {
    const notificationIcon = document.getElementById("notificationIcon");
    const mobileNotificationIcon = document.getElementById(
        "mobileNotificationIcon"
    );
    const notificationDropdown = document.getElementById(
        "notificationDropdown"
    );
    const notificationList = document.getElementById("notificationList");
    const notificationCounts = document.querySelectorAll(".notification-count");

    console.log("Notifications.js loaded - Setting up event listeners");

    // Toggle notification dropdown
    if (notificationIcon) {
        console.log("Notification icon found, adding click handler");

        notificationIcon.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            console.log("Notification icon clicked");

            if (notificationDropdown.style.display === "block") {
                notificationDropdown.style.display = "none";
            } else {
                notificationDropdown.style.display = "block";
                loadNotifications();
            }
        });
    } else {
        console.error("Notification icon not found");
    }

    // Close dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (
            notificationDropdown &&
            notificationDropdown.style.display === "block" &&
            !event.target.closest("#notificationIcon") &&
            !event.target.closest("#notificationDropdown")
        ) {
            notificationDropdown.style.display = "none";
        }
    });

    // Mobile notifications - redirect to notifications page
    if (mobileNotificationIcon) {
        mobileNotificationIcon.addEventListener("click", function () {
            window.location.href = "/notifications";
        });
    }

    // Listen for notifications from echo.js
    document.addEventListener("likeNotificationReceived", function (e) {
        console.log("Notification received in notifications.js:", e.detail);

        // Reload notifications if dropdown is open
        if (
            notificationDropdown &&
            notificationDropdown.style.display === "block"
        ) {
            console.log("Dropdown is open, reloading notifications");
            loadNotifications();
        } else {
            console.log("Dropdown is closed, updating badge only");
        }
    });

    // Function to load notifications
    function loadNotifications() {
        console.log("Loading notifications");
        fetch("/notifications/likes")
            .then((response) => response.json())
            .then((data) => {
                console.log("Notifications loaded:", data);

                if (!notificationList) {
                    console.error("Notification list element not found");
                    return;
                }

                notificationList.innerHTML = "";

                // Update notification counts
                updateNotificationCounter(data);

                if (data.length === 0) {
                    notificationList.innerHTML = `
                        <div class="notification-item empty p-4 text-center text-gray-500">
                            <p>No notifications</p>
                        </div>
                    `;
                    return;
                }

                // Add notifications to the list
                data.forEach((notification) => {
                    addNotificationToList(notification);
                });
            })
            .catch((error) => {
                console.error("Error fetching notifications:", error);
                if (notificationList) {
                    notificationList.innerHTML = `
                        <div class="notification-item empty p-4 text-center text-red-500">
                            <p>Error loading notifications</p>
                        </div>
                    `;
                }
            });
    }

    function addNotificationToList(notification) {
        const isUnread = !notification.read_at;
        const notificationItem = document.createElement("div");
        notificationItem.className = `notification-item p-3 border-b border-gray-200 dark:border-gray-700 ${
            isUnread ? "bg-blue-50 dark:bg-blue-900/20" : ""
        } hover:bg-gray-100 dark:hover:bg-gray-700/50 cursor-pointer`;
        notificationItem.dataset.id = notification.id;

        // Format the date
        const date = new Date(notification.created_at);
        const formattedDate = new Intl.DateTimeFormat("en-US", {
            year: "numeric",
            month: "short",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        }).format(date);

        notificationItem.innerHTML = `
            <div class="notification-content">
                <p class="text-sm text-gray-800 dark:text-gray-200">${notification.data.message}</p>
                <small class="text-xs text-gray-500 dark:text-gray-400">${formattedDate}</small>
            </div>
        `;

        // Add click event to mark as read
        notificationItem.addEventListener("click", function () {
            markAsRead(notification.id);
            if (notification.data.url) {
                window.location.href = notification.data.url;
            }
        });

        notificationList.appendChild(notificationItem);
    }

    function updateNotificationCounter(notifications) {
        const unreadCount = notifications.filter((n) => !n.read_at).length;
        notificationCounts.forEach((count) => {
            if (unreadCount > 0) {
                count.textContent = unreadCount;
                count.style.display = "block";
            } else {
                count.style.display = "none";
            }
        });
    }

    // Function to mark notification as read
    function markAsRead(notificationId) {
        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        )?.content;
        if (!csrfToken) {
            console.error("CSRF token not found");
            return;
        }

        fetch("/notifications/mark-read", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ id: notificationId }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log("Notification marked as read:", data);
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch((error) =>
                console.error("Error marking notification as read:", error)
            );
    }

    // Initialize: load notifications to show count
    loadNotifications();

    // REAL-TIME NOTIFICATIONS SETUP
    // Check if Laravel Echo is available in the window object
    if (window.Echo) {
        const userId = document
            .querySelector('meta[name="user-id"]')
            ?.getAttribute("content");

        if (userId) {
            console.log("Setting up Echo listener for user:", userId);

            // Listen for notifications on the user's private channel
            window.Echo.private(`App.Models.User.${userId}`).notification(
                (notification) => {
                    console.log("New notification received:", notification);

                    // Play a notification sound if available
                    playNotificationSound();

                    // Add animation class to notification count
                    notificationCounts.forEach((count) => {
                        count.classList.add("new");
                        setTimeout(() => count.classList.remove("new"), 3000);
                    });

                    // Add notification to list if dropdown is open
                    if (
                        notification.type ===
                        "App\\Notifications\\LikeNotification"
                    ) {
                        // Show toast notification if available (optional)
                        showToast(notification.data.message, "New Like");

                        // Update notifications list if dropdown is open
                        if (
                            notificationDropdown &&
                            notificationDropdown.style.display === "block"
                        ) {
                            loadNotifications();
                        } else {
                            // Just update the counter badge
                            updateUnreadCount();
                        }
                    }
                }
            );
        } else {
            console.warn(
                "User ID not found, cannot setup real-time notifications"
            );
        }
    } else {
        console.warn(
            "Laravel Echo not found, real-time notifications will not work"
        );
    }

    function showToast(message, title) {
        // Check if we have a toast library (like toastr) available
        if (typeof toastr !== "undefined") {
            toastr.info(message, title, {
                closeButton: true,
                timeOut: 5000,
                positionClass: "toast-top-right",
            });
        } else {
            // Create a simple custom toast notification
            const toast = document.createElement("div");
            toast.className = "custom-toast";
            toast.innerHTML = `
                <div class="toast-header">
                    <strong>${title}</strong>
                    <button type="button" class="close-toast">&times;</button>
                </div>
                <div class="toast-body">${message}</div>
            `;
            document.body.appendChild(toast);

            // Display toast
            setTimeout(() => toast.classList.add("show"), 100);

            // Add close button functionality
            toast
                .querySelector(".close-toast")
                .addEventListener("click", () => {
                    toast.classList.remove("show");
                    setTimeout(() => toast.remove(), 300);
                });

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                toast.classList.remove("show");
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }
    }

    function playNotificationSound() {
        // Create audio element for notification sound
        const audio = new Audio("/notification-sound.mp3");
        audio.volume = 0.5;
        audio
            .play()
            .catch((e) => console.log("Failed to play notification sound:", e));
    }

    // Function to update badge count without reloading all notifications
    function updateUnreadCount() {
        fetch("/notifications/likes/count")
            .then((response) => response.json())
            .then((data) => {
                const unreadCount = data.count;
                notificationCounts.forEach((count) => {
                    if (unreadCount > 0) {
                        count.textContent = unreadCount;
                        count.style.display = "block";
                        count.classList.add("new");
                        setTimeout(() => count.classList.remove("new"), 3000);
                    } else {
                        count.style.display = "none";
                    }
                });
            })
            .catch((error) => {
                console.error("Error fetching notification count:", error);
            });
    }
});
