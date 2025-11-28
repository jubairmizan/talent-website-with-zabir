<!-- Chat Interface Component -->
<div id="chat-interface" class="fixed bottom-20 right-4 w-96 bg-white rounded-lg shadow-xl z-[100] hidden transform translate-y-full transition-all duration-300 ease-in-out">
    <div class="flex flex-col h-[600px] border border-gray-200 rounded-lg">
        <!-- Chat Header -->
        <div id="chat-header" class="flex justify-between items-center p-4 text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-t-lg border-b">
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center w-10 h-10 rounded-full bg-white/20">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 id="chat-participant-name" class="text-lg font-semibold">Select a conversation</h3>
                    <p id="chat-status" class="text-xs opacity-90">Online</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button id="chat-minimize" class="p-2 rounded-full transition-colors hover:bg-white/10">
                    <i data-lucide="minus" class="w-4 h-4"></i>
                </button>
                <button id="chat-close" class="p-2 rounded-full transition-colors hover:bg-white/10">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Messages Container -->
        <div id="messages-container" class="overflow-y-auto flex-1 p-4 space-y-4 bg-gray-50">
            <div id="loading-messages" class="flex hidden justify-center items-center py-8">
                <div class="w-8 h-8 rounded-full border-b-2 border-pink-500 animate-spin"></div>
                <span class="ml-2 text-gray-600">Loading messages...</span>
            </div>
            <div id="messages-list" class="space-y-4">
                <!-- Messages will be dynamically loaded here -->
            </div>
            <div id="error-message" class="hidden px-4 py-3 text-red-700 bg-red-100 rounded border border-red-400">
                <span id="error-text"></span>
            </div>
        </div>

        <!-- Message Input -->
        <div id="message-input-container" class="p-4 bg-white border-t">
            <form id="message-form" class="flex items-end space-x-2">
                <div class="flex-1">
                    <textarea
                        id="message-input"
                        placeholder="Type your message..."
                        class="p-3 w-full rounded-lg border border-gray-300 resize-none focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        rows="1"
                        maxlength="1000"
                    ></textarea>
                    <div class="flex justify-between items-center mt-1">
                        <span id="char-count" class="text-xs text-gray-500">0/1000</span>
                        <div id="typing-indicator" class="hidden text-xs text-gray-500">
                            <i data-lucide="more-horizontal" class="inline w-3 h-3 animate-pulse"></i>
                            Typing...
                        </div>
                    </div>
                </div>
                <button
                    type="submit"
                    id="send-button"
                    class="p-3 text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg transition-all duration-200 hover:from-pink-600 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled
                >
                    <i data-lucide="send" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Chat Toggle Button -->
<button id="chat-toggle" class="fixed bottom-4 right-4 z-[99] bg-gradient-to-r from-pink-500 to-purple-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
    <i data-lucide="message-circle" class="w-6 h-6"></i>
    <span id="unread-badge" class="flex hidden absolute -top-2 -right-2 justify-center items-center w-6 h-6 text-xs text-white bg-red-500 rounded-full">0</span>
</button>

<style>
/* Chat Interface Styles */
#chat-interface {
    max-height: 90vh;
}

#messages-container {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f7fafc;
}

#messages-container::-webkit-scrollbar {
    width: 6px;
}

#messages-container::-webkit-scrollbar-track {
    background: #f7fafc;
}

#messages-container::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

#messages-container::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

/* Message Styles */
.message {
    max-width: 80%;
    word-wrap: break-word;
}

.message.sent {
    margin-left: auto;
    color: #1f2937;
    position: relative;
}

.message.sent::after {
    content: '';
    position: absolute;
    right: -8px;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 20px;
    background: linear-gradient(135deg, #ec4899, #8b5cf6);
    border-radius: 2px;
}

.message.sent .message-content {
    border: 2px solid transparent;
    background: linear-gradient(white, white) padding-box,
                linear-gradient(135deg, #ec4899, #8b5cf6) border-box;
    font-weight: 500;
    letter-spacing: 0.01em;
}

.message.received {
    margin-right: auto;
    background: white;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.message-content {
    padding: 16px 20px;
    border-radius: 20px;
    font-size: 14px;
    line-height: 1.5;
    transition: all 0.2s ease;
}

.message-time {
    font-size: 11px;
    opacity: 0.6;
    margin-top: 6px;
    text-align: right;
    font-weight: 400;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 4px;
}

.message.received .message-time {
    text-align: left;
    justify-content: flex-start;
}

.message.sent:hover::after {
    height: 24px;
    width: 4px;
}

.message.sent:hover .message-content {
    transform: translateX(-2px);
    box-shadow: 0 4px 12px rgba(236, 72, 153, 0.15);
}

/* Animation for new messages */
.message.new {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Typing indicator animation */
.typing-dots {
    display: inline-flex;
    align-items: center;
}

.typing-dots span {
    height: 8px;
    width: 8px;
    background: #9ca3af;
    border-radius: 50%;
    display: inline-block;
    margin: 0 1px;
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dots span:nth-child(1) { animation-delay: -0.32s; }
.typing-dots span:nth-child(2) { animation-delay: -0.16s; }

@keyframes typing {
    0%, 80%, 100% {
        transform: scale(0.8);
        opacity: 0.5;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Delivery status */
.delivery-status {
    font-size: 0.7rem;
    opacity: 0.6;
    margin-top: 2px;
}

.status-sent { color: #6b7280; }
.status-delivered { color: #10b981; }
.status-read { color: #3b82f6; }

/* Error message styles */
.error-message {
    background-color: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
    padding: 12px;
    border-radius: 8px;
    margin: 8px 0;
}

/* Network status indicator */
.network-status {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #10b981;
}

.network-status.offline {
    background-color: #ef4444;
}
</style>

<script>
class ChatInterface {
    constructor() {
        this.currentConversationId = null;
        this.currentParticipant = null;
        this.isVisible = false;
        this.isMinimized = false;
        this.messages = [];
        this.unreadCount = 0;
        this.isOnline = navigator.onLine;
        this.retryAttempts = 0;
        this.maxRetryAttempts = 3;
        this.onlineUsers = new Map();

        this.initializeElements();
        this.bindEvents();
        this.setupAutoResize();
        this.loadUnreadCount();
        this.setupNetworkMonitoring();

        // Initialize Echo for real-time messaging (if available)
        if (typeof Echo !== 'undefined') {
            this.initializeEcho();
            this.initializePresence();
        }
    }

    initializeElements() {
        this.chatInterface = document.getElementById('chat-interface');
        this.chatToggle = document.getElementById('chat-toggle');
        this.chatClose = document.getElementById('chat-close');
        this.chatMinimize = document.getElementById('chat-minimize');
        this.messagesList = document.getElementById('messages-list');
        this.messagesContainer = document.getElementById('messages-container');
        this.messageForm = document.getElementById('message-form');
        this.messageInput = document.getElementById('message-input');
        this.sendButton = document.getElementById('send-button');
        this.participantName = document.getElementById('chat-participant-name');
        this.chatStatus = document.getElementById('chat-status');
        this.charCount = document.getElementById('char-count');
        this.unreadBadge = document.getElementById('unread-badge');
        this.loadingMessages = document.getElementById('loading-messages');
        this.errorMessage = document.getElementById('error-message');
        this.errorText = document.getElementById('error-text');
    }

    bindEvents() {
        this.chatToggle.addEventListener('click', () => this.toggle());
        this.chatClose.addEventListener('click', () => this.hide());
        this.chatMinimize.addEventListener('click', () => this.minimize());
        this.messageForm.addEventListener('submit', (e) => this.sendMessage(e));
        this.messageInput.addEventListener('input', () => this.updateCharCount());
        this.messageInput.addEventListener('keydown', (e) => this.handleKeyDown(e));
    }

    setupAutoResize() {
        this.messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    }

    setupNetworkMonitoring() {
        window.addEventListener('online', () => {
            this.isOnline = true;
            this.hideError();
            this.updateConnectionStatus();
        });

        window.addEventListener('offline', () => {
            this.isOnline = false;
            this.showError('You are offline. Messages will be sent when connection is restored.');
            this.updateConnectionStatus();
        });
    }

    updateConnectionStatus() {
        if (this.chatStatus) {
            this.chatStatus.textContent = this.isOnline ? 'Online' : 'Offline';
        }
    }

    toggle() {
        if (this.isVisible) {
            this.hide();
        } else {
            this.show();
        }
    }

    show() {
        this.isVisible = true;
        this.isMinimized = false;
        this.chatInterface.classList.remove('hidden');
        setTimeout(() => {
            this.chatInterface.classList.remove('translate-y-full');
        }, 10);
        this.messageInput.focus();

        if (!this.currentConversationId && window.Laravel?.user?.role === 'creator') {
            this.openLatestConversationForCreator();
        }
    }

    hide() {
        this.isVisible = false;
        this.chatInterface.classList.add('translate-y-full');
        setTimeout(() => {
            this.chatInterface.classList.add('hidden');
        }, 300);
    }

    minimize() {
        this.isMinimized = !this.isMinimized;
        if (this.isMinimized) {
            this.chatInterface.style.height = '60px';
            this.messagesContainer.style.display = 'none';
            document.getElementById('message-input-container').style.display = 'none';
        } else {
            this.chatInterface.style.height = '600px';
            this.messagesContainer.style.display = 'block';
            document.getElementById('message-input-container').style.display = 'block';
        }
    }

    async openConversation(creatorId, creatorName = null) {
        if (!creatorId) {
            this.handleError(new Error('Creator ID is required'), 'open_conversation');
            return;
        }

        try {
            // Check if creator is available (optional check)
            const isAvailable = await this.checkCreatorAvailability(creatorId);
            if (!isAvailable) {
                this.showNotification('This creator is currently unavailable for chat.', 'info');
                return;
            }

            this.show();
            this.showLoading();
            this.hideError();

            // Set participant info
            this.currentParticipant = { id: creatorId, name: creatorName };
            if (creatorName) {
                this.participantName.textContent = creatorName;
            }

            let conversation = null;
            if (window.Laravel?.user?.role === 'member') {
                conversation = await this.getOrCreateConversation(creatorId);
            } else {
                // For creators, find existing conversation with this participant
                const conv = await this.findConversationWithParticipant(creatorId);
                if (!conv) {
                    this.showNotification('No existing conversation with this member.', 'error');
                    return;
                }
                conversation = conv;
            }

            if (conversation) {
                this.currentConversationId = conversation.id;
                const name = conversation.creator_name || conversation.participant_name || creatorName || 'User';
                this.participantName.textContent = name;
                this.updateParticipantStatus();

                // Load messages for this conversation
                await this.loadMessages();

                // Join real-time channel
                this.joinConversationChannel();

                this.showNotification('Chat opened successfully!', 'success');
            }

        } catch (error) {
            console.error('Error opening conversation:', error);
            this.handleError(error, 'open_conversation');
            this.showError('Failed to open conversation. Please try again.');
        } finally {
            this.hideLoading();
        }
    }

    async findConversationWithParticipant(participantId) {
        try {
            const response = await fetch('/conversations', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (!response.ok) return null;
            const data = await response.json();
            const list = data.conversations || [];
            return list.find(c => String(c.participant_id) === String(participantId)) || null;
        } catch (e) {
            return null;
        }
    }

    async getOrCreateConversation(creatorId) {
        try {
            const response = await fetch('/conversations/get-or-create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ creator_id: creatorId })
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw { response: { status: response.status, data: errorData } };
            }

            const data = await response.json();

            if (data.success) {
                return data.conversation;
            } else {
                throw new Error(data.message || 'Failed to create conversation');
            }

        } catch (error) {
            this.handleError(error, 'get_or_create_conversation');
            throw error;
        }
    }

    async loadMessages() {
        if (!this.currentConversationId) {
            this.showError('No conversation selected');
            return;
        }

        try {
            this.showLoading();

            const response = await fetch(`/conversations/${this.currentConversationId}/messages`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw { response: { status: response.status, data: errorData } };
            }

            const data = await response.json();

            if (data.success) {
                this.messages = data.messages || [];
                this.renderMessages();
                // Mark messages as read
                await this.markMessagesAsRead();
            } else {
                throw new Error(data.message || 'Failed to load messages');
            }
        } catch (error) {
            this.handleError(error, 'load_messages');
            this.showError('Failed to load messages. Please try again.');
        } finally {
            this.hideLoading();
        }
    }

    renderMessages() {
        if (!this.messagesList) return;

        const currentUserId = window.Laravel?.user?.id;

        this.messagesList.innerHTML = this.messages.map(message => {
            const isSent = message.sender_id == currentUserId;
            const messageClass = isSent ? 'sent' : 'received';
            const timeAgo = this.formatTimeAgo(new Date(message.created_at));

            return `
                <div class="message ${messageClass}">
                    <div class="message-content">
                        ${this.escapeHtml(message.message)}
                    </div>
                    <div class="message-time">
                        ${timeAgo}
                        ${isSent ? (message.is_read ? '<i data-lucide="check-check" class="inline ml-1 w-3 h-3"></i>' : '<i data-lucide="check" class="inline ml-1 w-3 h-3"></i>') : ''}
                    </div>
                </div>
            `;
        }).join('');

        // Re-initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    async sendMessage(e) {
        e.preventDefault();

        const messageText = this.messageInput.value.trim();
        if (!messageText || !this.currentConversationId) return;

        if (!this.isOnline) {
            this.showError('You are offline. Please check your internet connection.');
            return;
        }

        // Check if user is authenticated
        if (!window.Laravel?.user?.id) {
            this.showError('You must be logged in to send messages.');
            return;
        }

        // Disable input while sending
        this.messageInput.disabled = true;
        this.sendButton.disabled = true;

        try {
            console.log('Sending message:', {
                conversationId: this.currentConversationId,
                message: messageText,
                userId: window.Laravel?.user?.id
            });

            // Add message to UI immediately (optimistic update)
            const tempMessage = {
                id: 'temp-' + Date.now(),
                message: messageText,
                sender_id: window.Laravel?.user?.id,
                created_at: new Date().toISOString(),
                is_read: false
            };

            this.messages.push(tempMessage);
            this.renderMessages();
            this.scrollToBottom();

            // Clear input
            this.messageInput.value = '';
            this.updateCharCount();

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                throw new Error('CSRF token not found. Please refresh the page.');
            }

            // Send to server
            const response = await fetch(`/conversations/${this.currentConversationId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: messageText })
            });

            console.log('Response status:', response.status);
            console.log('Response headers:', Object.fromEntries(response.headers.entries()));

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Error response:', errorText);

                let errorData = {};
                try {
                    errorData = JSON.parse(errorText);
                } catch (e) {
                    errorData = { message: `HTTP ${response.status}: ${errorText}` };
                }

                throw { response: { status: response.status, data: errorData } };
            }

            const data = await response.json();
            console.log('Success response:', data);

            if (data.success) {
                // Replace temp message with real message
                const tempIndex = this.messages.findIndex(m => m.id === tempMessage.id);
                if (tempIndex !== -1) {
                    this.messages[tempIndex] = data.message;
                    this.renderMessages();
                }
                this.retryAttempts = 0; // Reset retry attempts on success
                console.log('Message sent successfully');
            } else {
                throw new Error(data.message || 'Failed to send message');
            }

        } catch (error) {
            console.error('Error sending message:', error);

            // Remove temp message on error
            this.messages = this.messages.filter(m => m.id !== tempMessage.id);
            this.renderMessages();

            // Show detailed error message
            let errorMessage = 'Failed to send message.';
            if (error.response?.status === 401) {
                errorMessage = 'You are not authorized. Please log in again.';
            } else if (error.response?.status === 403) {
                errorMessage = error.response.data?.message || 'You are not allowed to send messages in this conversation.';
            } else if (error.response?.status === 404) {
                errorMessage = 'Conversation not found. Please refresh the page.';
            } else if (error.response?.status === 422) {
                errorMessage = error.response.data?.message || 'Invalid message data.';
            } else if (error.message) {
                errorMessage = error.message;
            }

            // Handle retry logic
            if (this.retryAttempts < this.maxRetryAttempts && error.response?.status !== 401 && error.response?.status !== 403) {
                this.retryAttempts++;
                this.showError(`${errorMessage} Retrying... (${this.retryAttempts}/${this.maxRetryAttempts})`);

                // Retry after delay
                setTimeout(() => {
                    this.messageInput.value = messageText;
                    this.sendMessage(e);
                }, 2000);
            } else {
                this.showError(errorMessage);
                this.messageInput.value = messageText; // Restore message text
                this.retryAttempts = 0;
            }

        } finally {
            // Re-enable input
            this.messageInput.disabled = false;
            this.sendButton.disabled = false;
            this.messageInput.focus();
        }
    }

    async markMessagesAsRead() {
        if (!this.currentConversationId) return;

        try {
            await fetch(`/conversations/${this.currentConversationId}/messages/mark-read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            // Update unread count
            this.loadUnreadCount();

        } catch (error) {
            console.error('Error marking messages as read:', error);
        }
    }

    async loadUnreadCount() {
        try {
            const response = await fetch('/messages/unread-count', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                this.updateUnreadBadge(data.count);
            }

        } catch (error) {
            console.error('Error loading unread count:', error);
        }
    }

    updateUnreadBadge(count) {
        this.unreadCount = count;

        if (count > 0) {
            this.unreadBadge.textContent = count > 99 ? '99+' : count;
            this.unreadBadge.classList.remove('hidden');
        } else {
            this.unreadBadge.classList.add('hidden');
        }
    }

    updateCharCount() {
        const length = this.messageInput.value.length;
        this.charCount.textContent = `${length}/1000`;

        // Enable/disable send button
        this.sendButton.disabled = length === 0 || length > 1000;
    }

    handleKeyDown(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.sendMessage(e);
        }
    }

    scrollToBottom() {
        if (this.messagesContainer) {
            this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
        }
    }

    showLoading() {
        if (this.loadingMessages) {
            this.loadingMessages.classList.remove('hidden');
        }
    }

    hideLoading() {
        if (this.loadingMessages) {
            this.loadingMessages.classList.add('hidden');
        }
    }

    showError(message) {
        if (this.errorMessage && this.errorText) {
            this.errorText.textContent = message;
            this.errorMessage.classList.remove('hidden');

            // Auto-hide error after 5 seconds
            setTimeout(() => {
                this.hideError();
            }, 5000);
        }
    }

    hideError() {
        if (this.errorMessage) {
            this.errorMessage.classList.add('hidden');
        }
    }

    initializeEcho() {
        if (typeof Echo === 'undefined') {
            console.warn('Laravel Echo not available for real-time messaging');
            return;
        }

        console.log('Echo real-time messaging ready');
    }

    initializePresence() {
        if (typeof Echo === 'undefined') return;
        Echo.join('online')
            .here((users) => {
                this.onlineUsers.clear();
                users.forEach(u => this.onlineUsers.set(u.id, u));
                this.updateParticipantStatus();
            })
            .joining((user) => {
                this.onlineUsers.set(user.id, user);
                this.updateParticipantStatus();
            })
            .leaving((user) => {
                this.onlineUsers.delete(user.id);
                this.updateParticipantStatus();
            });
    }

    updateParticipantStatus() {
        if (!this.currentParticipant) return;
        const isParticipantOnline = this.onlineUsers.has(this.currentParticipant.id);
        if (this.chatStatus) {
            this.chatStatus.textContent = isParticipantOnline ? 'Online' : 'Offline';
        }
    }

    joinConversationChannel() {
        if (typeof Echo !== 'undefined' && this.currentConversationId) {
            Echo.private(`conversation.${this.currentConversationId}`)
                .listen('.message.sent', (e) => {
                    const incoming = e && e.message ? e.message : null;
                    if (!incoming) return;

                    if (this.messages.some(m => m.id === incoming.id)) return;

                    const currentUserId = window.Laravel?.user?.id;
                    if (incoming.sender_id === currentUserId) {
                        const tempIndex = this.messages.findIndex(m => String(m.id).startsWith('temp-') && m.sender_id === currentUserId && m.message === incoming.message);
                        if (tempIndex !== -1) {
                            this.messages[tempIndex] = incoming;
                            this.renderMessages();
                            this.scrollToBottom();
                            return;
                        }
                    }

                    this.messages.push(incoming);
                    this.renderMessages();
                    this.scrollToBottom();

                    if (!this.isVisible) {
                        this.updateUnreadBadge(this.unreadCount + 1);
                    } else {
                        this.markMessagesAsRead();
                    }
                });
        }
    }

    formatTimeAgo(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;

        return date.toLocaleDateString();
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Error handling
    handleError(error, context = 'chat') {
        console.error(`Chat error (${context}):`, error);

        let message = 'An error occurred. Please try again.';

        if (error.response) {
            // HTTP error responses
            switch (error.response.status) {
                case 401:
                    message = 'Please log in to continue chatting.';
                    // Redirect to login if needed
                    if (error.response.data?.redirect) {
                        window.location.href = error.response.data.redirect;
                        return;
                    }
                    break;
                case 403:
                    message = 'You do not have permission to perform this action.';
                    break;
                case 404:
                    message = context === 'conversation' ? 'Conversation not found.' : 'User not found.';
                    break;
                case 422:
                    // Validation errors
                    if (error.response.data?.errors) {
                        const errors = Object.values(error.response.data.errors).flat();
                        message = errors.join(' ');
                    } else if (error.response.data?.message) {
                        message = error.response.data.message;
                    }
                    break;
                case 429:
                    message = 'Too many requests. Please wait a moment before trying again.';
                    break;
                case 500:
                    message = 'Server error. Please try again later.';
                    break;
                default:
                    if (error.response.data?.message) {
                        message = error.response.data.message;
                    }
            }
        } else if (error.request) {
            // Network error
            message = 'Network error. Please check your connection and try again.';
        } else if (error.message) {
            // Other errors
            message = error.message;
        }

        this.showNotification(message, 'error');
    }

    // Show notification to user
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `chat-notification chat-notification-${type}`;
        notification.innerHTML = `
            <div class="flex justify-between items-center p-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <i data-lucide="${type === 'error' ? 'alert-circle' : type === 'success' ? 'check-circle' : 'info'}" class="mr-2 w-5 h-5"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        `;

        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            max-width: 400px;
            background: ${type === 'error' ? '#fee2e2' : type === 'success' ? '#dcfce7' : '#dbeafe'};
            color: ${type === 'error' ? '#dc2626' : type === 'success' ? '#16a34a' : '#2563eb'};
            border: 1px solid ${type === 'error' ? '#fecaca' : type === 'success' ? '#bbf7d0' : '#bfdbfe'};
            border-radius: 0.5rem;
            animation: slideInRight 0.3s ease-out;
        `;

        // Add to page
        document.body.appendChild(notification);

        // Re-initialize Lucide icons for the notification
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    // Check if creator is available for chat
    async checkCreatorAvailability(creatorId) {
        try {
            const response = await fetch(`/api/creators/${creatorId}/availability`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Failed to check creator availability');
            }

            const data = await response.json();
            return data.available;
        } catch (error) {
            console.warn('Could not check creator availability:', error);
            return true; // Assume available if check fails
        }
    }

    // Handle network connectivity issues
    handleNetworkError() {
        this.showNotification('Connection lost. Trying to reconnect...', 'error');

        // Try to reconnect Echo if it exists
        if (window.Echo) {
            try {
                window.Echo.disconnect();
                // Reinitialize Echo connection
                setTimeout(() => {
                    if (window.Echo) {
                        window.Echo.connect();
                    }
                }, 2000);
            } catch (error) {
                console.error('Failed to reconnect Echo:', error);
            }
        }
    }

    async openLatestConversationForCreator() {
        try {
            const response = await fetch('/conversations', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (!response.ok) return;
            const data = await response.json();
            const list = Array.isArray(data.conversations) ? data.conversations : [];
            if (!list.length) return;

            const c = list[0];
            this.currentConversationId = c.id;
            this.currentParticipant = { id: c.participant_id, name: c.participant_name };
            if (c.participant_name) {
                this.participantName.textContent = c.participant_name;
            }
            this.updateParticipantStatus();
            await this.loadMessages();
            this.joinConversationChannel();
        } catch (e) {
        }
    }
}

// Initialize chat interface when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.Laravel !== 'undefined' && window.Laravel.user) {
        window.chatInterface = new ChatInterface();
    }
});

// Global function to open conversation (called from other parts of the app)
function openConversation(creatorId, creatorName = null) {
    if (window.chatInterface) {
        window.chatInterface.openConversation(creatorId, creatorName);
    } else {
        console.error('Chat system is not available. Please refresh the page.');
        alert('Chat system is not available. Please refresh the page.');
    }
}

// Open conversation by ID (for creator picking from conversation list)
function openConversationById(conversationId, participantId, participantName = null) {
    if (!window.chatInterface) {
        alert('Chat system is not available. Please refresh the page.');
        return;
    }
    window.chatInterface.currentConversationId = conversationId;
    window.chatInterface.currentParticipant = { id: participantId, name: participantName };
    if (participantName) {
        window.chatInterface.participantName.textContent = participantName;
    }
    window.chatInterface.updateParticipantStatus();
    window.chatInterface.show();
    window.chatInterface.loadMessages().then(() => {
        window.chatInterface.joinConversationChannel();
    });
}
</script>
