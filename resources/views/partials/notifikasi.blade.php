<style>
    .notification-dropdown {
        width: 350px;
        max-height: 400px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
        display: block;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .notification-item:hover {
        background-color: #f8f9fa;
    }

    .notification-item.unread {
        background-color: #f8f9fa;
    }

    .notification-item.unread .notification-title {
        font-weight: bold;
    }

    .notification-content {
        margin-left: 25px;
    }

    .notification-time {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .notification-message {
        color: #666;
        font-size: 0.9rem;
        margin-top: 3px;
    }

    /* Modified badge position to be closer to the bell icon */
    .badge-notification {
        position: absolute;
        top: -5px;
        right: -5px;
        font-size: 0.75rem;
        background-color: #e0163e;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        min-width: 15px;
        height: 15px;
        line-height: 12px;
        text-align: center;
             
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .notification-header {
        padding: 10px 15px;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        font-weight: bold;
    }

    /* Animation for new notifications */
    .notification-item.new-notification {
        animation: highlightNew 2s ease-out;
    }

    @keyframes highlightNew {
        0% { background-color: #fff3cd; }
        100% { background-color: inherit; }
    }
    
    /* Bell icon container */
    .bell-container {
        position: relative;
        display: inline-block;
    }
</style>

<li class="nav-item">
    @php
        $unreadNotifications = Auth::user()->notifications()->where('is_read', 0)->count();
        $recentNotifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->take(100)
            ->get();
    @endphp

    <!-- Modified: Removed dropdown-toggle class and added bell-container -->
    <a class="nav-link position-relative bell-container" href="#" id="notificationDropdown" 
       role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell"></i>
        @if($unreadNotifications > 0)
            <span class="badge-notification">{{ $unreadNotifications }}</span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-right notification-dropdown" 
         aria-labelledby="notificationDropdown">
        <div class="notification-header">
            <i class="fas fa-bell mr-2"></i>
            Notifikasi
            @if($unreadNotifications > 0)
                <span class="badge badge-danger ml-2">{{ $unreadNotifications }}</span>
            @endif
        </div>

        <div id="notifications-container">
            @if($recentNotifications->count() > 0)
                @foreach($recentNotifications as $notification)
                    <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}"
                         data-id="{{ $notification->id }}">
                        @if(str_contains(strtolower($notification->title), 'setup'))
                            <i class="fas fa-cog text-primary"></i>
                        @elseif(str_contains(strtolower($notification->title), 'downtime'))
                            <i class="fas fa-tools text-warning"></i>
                        @elseif(str_contains(strtolower($notification->title), 'error'))
                            <i class="fas fa-exclamation-circle text-danger"></i>
                        @else
                            <i class="fas fa-info-circle text-info"></i>
                        @endif

                        <div class="notification-content">
                            <div class="notification-title">
                                {{ $notification->title }}
                            </div>
                            <div class="notification-message">
                                {{ $notification->message }}
                            </div>
                            <div class="notification-time">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach 
            @else
                <div class="p-3 text-center text-muted">
                    Tidak ada notifikasi
                </div>
            @endif
        </div>
    </div>
</li>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Define routes globally
        const routes = {
            downtime: '{{ route("downtime.index") }}',
            setup: '{{ route("setup.index") }}',
            qcSetup: '{{ route("rekapsetup.index") }}',
            qcDowntime: '{{ route("rekapdowntime.index") }}'
        };
        
        // Audio element for notifications
        const notificationSound = document.getElementById('notificationSound');
        
        // Initialize Echo for real-time notifications
        if (typeof window.Echo !== 'undefined') {
            const userId = {{ Auth::id() }};
            console.log('Echo initialized, listening for user:', userId);
            
            window.Echo.private(`notifications.${userId}`)
                .listen('.new-notification', (e) => {
                    console.log('Notification received:', e);
                    
                    // Add notification to UI
                    const newNotification = createNotificationElement(e.notification);
                    
                    const container = document.querySelector('#notifications-container');
                    if (container.querySelector('.text-muted')) {
                        container.innerHTML = '';
                    }
                    container.insertBefore(newNotification, container.firstChild);
                    
                    updateNotificationCount();
                    
                    // Play notification sound
                    playNotificationSound();
                    
                    // Show browser notification
                    showBrowserNotification(e.notification);
                });
        } else {
            console.error('Echo not properly initialized!');
        }
        
        // Function to play notification sound
        function playNotificationSound() {
            try {
                if (notificationSound) {
                    notificationSound.currentTime = 0;
                    
                    const playPromise = notificationSound.play();
                    
                    if (playPromise !== undefined) {
                        playPromise.catch(error => {
                            console.error('Error playing sound:', error);
                        });
                    }
                }
            } catch (error) {
                console.error('Error in playNotificationSound:', error);
            }
        }
        
        // Function to show browser notification
        function showBrowserNotification(notification) {
            if (Notification.permission === 'granted') {
                const browserNotification = new Notification(notification.title, {
                    body: notification.message,
                    icon: '/favicon.ico'
                });
                
                browserNotification.onclick = function() {
                    window.focus();
                    this.close();
                };
            }
        }
        
        // Function to create notification element
        function createNotificationElement(notification) {
            const element = document.createElement('div');
            element.className = 'notification-item unread new-notification';
            element.setAttribute('data-id', notification.id);
            
            let iconClass = 'fas fa-info-circle text-info';
            const title = notification.title.toLowerCase();
            
            if (title.includes('setup')) {
                iconClass = 'fas fa-cog text-primary';
            } else if (title.includes('downtime')) {
                iconClass = 'fas fa-tools text-warning';
            } else if (title.includes('error')) {
                iconClass = 'fas fa-exclamation-circle text-danger';
            }
            
            const createdAt = new Date(notification.created_at).toLocaleString();
            element.innerHTML = `
                <i class="${iconClass}"></i>
                <div class="notification-content">
                    <div class="notification-title">${notification.title}</div>
                    <div class="notification-message">${notification.message}</div>
                    <div class="notification-time">${createdAt}</div>
                </div>
            `;
            
            element.addEventListener('click', function() {
                handleNotificationClick(notification.id, element);
            });
            
            return element;
        }
        
        // Function to handle notification click
        function handleNotificationClick(notificationId, element) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove notification from UI
                    element.remove();
                    
                    // Update badge count
                    updateNotificationCount();
                    
                    // Redirect to URL from server
                    window.location.href = data.redirect;
                    
                    // Check if no notifications remain
                    const container = document.getElementById('notifications-container');
                    if (!container.querySelector('.notification-item')) {
                        container.innerHTML = '<div class="p-3 text-center text-muted">Tidak ada notifikasi</div>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // Function to update notification counter
        function updateNotificationCount() {
            const count = document.querySelectorAll('.notification-item.unread').length;
            const badge = document.querySelector('.badge-notification');
            const headerBadge = document.querySelector('.notification-header .badge');
            
            if (count > 0) {
                // Update or create badge on icon
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = 'flex';
                } else {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'badge-notification';
                    newBadge.textContent = count;
                    document.querySelector('#notificationDropdown').appendChild(newBadge);
                }
                
                // Update badge in header
                if (headerBadge) {
                    headerBadge.textContent = count;
                }
            } else {
                // Remove badges if no notifications
                if (badge) badge.style.display = 'none';
                if (headerBadge) headerBadge.remove();
            }
        }
        
        // Initialize event handlers for existing notifications
        document.querySelectorAll('.notification-item').forEach(item => {
            const notificationId = item.getAttribute('data-id');
            item.addEventListener('click', function() {
                handleNotificationClick(notificationId, item);
            });
        });
        
        // Initialize audio on user interaction
        document.addEventListener('click', function enableAudio() {
            if (notificationSound) {
                notificationSound.play().then(() => {
                    notificationSound.pause();
                    notificationSound.currentTime = 0;
                }).catch(err => {
                    console.error('Audio initialization failed:', err);
                });
            }
            document.removeEventListener('click', enableAudio);
        }, { once: true });
        
        // Request notification permission
        if ('Notification' in window && Notification.permission !== 'granted') {
            Notification.requestPermission();
        }
    });
</script>