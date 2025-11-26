@extends('admin.layout')

@section('title', 'Contact Management')
@section('page-title', 'Contact Messages')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-envelope me-2"></i>
            Contact Messages
          </h5>
          <div class="d-flex gap-2">
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-filter me-1"></i>
                Filter by Status
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.contacts') }}">All Messages</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.contacts', ['status' => 'unread']) }}">Unread</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.contacts', ['status' => 'read']) }}">Read</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.contacts', ['status' => 'replied']) }}">Replied</a></li>
              </ul>
            </div>
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-sort me-1"></i>
                Sort by
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.contacts', ['sort' => 'newest']) }}">Newest First</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.contacts', ['sort' => 'oldest']) }}">Oldest First</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.contacts', ['sort' => 'priority']) }}">Priority</a></li>
              </ul>
            </div>
            <button class="btn btn-outline-secondary" onclick="bulkMarkAsRead()">
              <i class="fas fa-check me-1"></i>
              Bulk Mark as Read
            </button>
          </div>
        </div>
        <div class="card-body">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle me-2"></i>
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th width="40">
                    <input type="checkbox" id="selectAll" class="form-check-input">
                  </th>
                  <th>Contact Info</th>
                  <th>Subject</th>
                  <th>Priority</th>
                  <th>Status</th>
                  <th>Received</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($contacts as $contact)
                  <tr class="{{ $contact->status === 'unread' ? 'table-warning' : '' }}">
                    <td>
                      <input type="checkbox" class="form-check-input contact-checkbox" value="{{ $contact->id }}">
                    </td>
                    <td>
                      <div class="d-flex align-items-start">
                        <div class="avatar me-3" style="width: 40px; height: 40px; background: var(--accent-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                          {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </div>
                        <div>
                          <strong>{{ $contact->name }}</strong>
                          <br>
                          <small class="text-muted">
                            <i class="fas fa-envelope me-1"></i>
                            {{ $contact->email }}
                          </small>
                          @if ($contact->phone)
                            <br>
                            <small class="text-muted">
                              <i class="fas fa-phone me-1"></i>
                              {{ $contact->phone }}
                            </small>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td>
                      <div>
                        <strong>{{ Str::limit($contact->subject, 40) }}</strong>
                        <br>
                        <small class="text-muted">{{ Str::limit($contact->message, 80) }}</small>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-{{ $contact->priority === 'high' ? 'danger' : ($contact->priority === 'medium' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($contact->priority ?? 'normal') }}
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-{{ $contact->status === 'unread' ? 'warning' : ($contact->status === 'replied' ? 'success' : 'info') }}">
                        {{ ucfirst($contact->status) }}
                      </span>
                    </td>
                    <td>
                      {{ $contact->created_at->format('M d, Y') }}
                      <br>
                      <small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                      <br>
                      <small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="viewMessage({{ $contact->id }})" title="View Message">
                          <i class="fas fa-eye"></i>
                        </button>

                        @if ($contact->status !== 'replied')
                          <button type="button" class="btn btn-sm btn-outline-primary" onclick="replyMessage({{ $contact->id }})" title="Reply">
                            <i class="fas fa-reply"></i>
                          </button>
                        @endif

                        @if ($contact->status === 'unread')
                          <button type="button" class="btn btn-sm btn-outline-success" onclick="markAsRead({{ $contact->id }})" title="Mark as Read">
                            <i class="fas fa-check"></i>
                          </button>
                        @endif

                        <div class="dropdown">
                          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" title="More Actions">
                            <i class="fas fa-ellipsis-v"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="setPriority({{ $contact->id }}, 'high')">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i>High Priority
                              </a></li>
                            <li><a class="dropdown-item" href="#" onclick="setPriority({{ $contact->id }}, 'medium')">
                                <i class="fas fa-exclamation text-warning me-2"></i>Medium Priority
                              </a></li>
                            <li><a class="dropdown-item" href="#" onclick="setPriority({{ $contact->id }}, 'normal')">
                                <i class="fas fa-minus text-secondary me-2"></i>Normal Priority
                              </a></li>
                            <li>
                              <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#" onclick="archiveMessage({{ $contact->id }})">
                                <i class="fas fa-archive text-muted me-2"></i>Archive
                              </a></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $contact->id }}, '{{ addslashes($contact->subject) }}')">
                                <i class="fas fa-trash me-2"></i>Delete
                              </a></li>
                          </ul>
                        </div>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-4">
                      <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                      <p class="text-muted">No contact messages found</p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          @if ($contacts->hasPages())
            <div class="d-flex justify-content-center mt-4">
              {{ $contacts->links('pagination.bootstrap') }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row mt-4">
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
          <h4>{{ number_format($stats['total_messages']) }}</h4>
          <p class="text-muted mb-0">Total Messages</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <i class="fas fa-envelope-open fa-2x text-warning mb-2"></i>
          <h4>{{ number_format($stats['unread_messages']) }}</h4>
          <p class="text-muted mb-0">Unread</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <i class="fas fa-reply fa-2x text-success mb-2"></i>
          <h4>{{ number_format($stats['replied_messages']) }}</h4>
          <p class="text-muted mb-0">Replied</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
          <h4>{{ number_format($stats['high_priority']) }}</h4>
          <p class="text-muted mb-0">High Priority</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Message View Modal -->
  <div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-envelope me-2"></i>
            Contact Message
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="messageContent">
          <div class="text-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="replyFromModal()">
            <i class="fas fa-reply me-1"></i>
            Reply
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Reply Modal -->
  <div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-reply me-2"></i>
            Reply to Message
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="replyForm" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="replySubject" class="form-label">Subject</label>
              <input type="text" class="form-control" id="replySubject" name="subject" required>
            </div>
            <div class="mb-3">
              <label for="replyMessage" class="form-label">Message</label>
              <textarea class="form-control" id="replyMessage" name="message" rows="8" required></textarea>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="markAsReplied" name="mark_as_replied" checked>
              <label class="form-check-label" for="markAsReplied">
                Mark original message as replied
              </label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-paper-plane me-1"></i>
              Send Reply
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
            Confirm Delete
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete the message <strong id="deleteMessageSubject"></strong>?</p>
          <p class="text-danger">
            <i class="fas fa-warning me-1"></i>
            This action cannot be undone.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <form id="deleteForm" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-trash me-1"></i>
              Delete Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    let currentMessageId = null;

    function viewMessage(messageId) {
      currentMessageId = messageId;
      const modal = new bootstrap.Modal(document.getElementById('messageModal'));
      const content = document.getElementById('messageContent');

      // Show loading spinner
      content.innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

      modal.show();

      // Simulate loading message content (replace with actual AJAX call)
      setTimeout(() => {
        content.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>From:</h6>
                        <p>John Doe<br><small class="text-muted">john.doe@example.com</small></p>
                        
                        <h6>Phone:</h6>
                        <p>+1 (555) 123-4567</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Subject:</h6>
                        <p>Website Design Inquiry</p>
                        
                        <h6>Received:</h6>
                        <p>January 15, 2024 at 2:30 PM</p>
                    </div>
                </div>
                <hr>
                <h6>Message:</h6>
                <div class="bg-light p-3 rounded">
                    <p>Hello, I'm interested in your web design services. I have a small business and need a professional website. Could you please provide more information about your packages and pricing?</p>
                    <p>I'm looking for something modern and mobile-friendly. Please let me know your availability for a consultation.</p>
                    <p>Thank you!</p>
                </div>
            `;
      }, 1000);
    }

    function replyMessage(messageId) {
      currentMessageId = messageId;
      document.getElementById('replyForm').action = `/admin/contacts/${messageId}/reply`;
      document.getElementById('replySubject').value = 'Re: Website Design Inquiry';
      new bootstrap.Modal(document.getElementById('replyModal')).show();
    }

    function replyFromModal() {
      if (currentMessageId) {
        document.getElementById('messageModal').querySelector('.btn-close').click();
        replyMessage(currentMessageId);
      }
    }

    function markAsRead(messageId) {
      // Implement mark as read functionality
      console.log('Marking as read:', messageId);
    }

    function setPriority(messageId, priority) {
      // Implement set priority functionality
      console.log('Setting priority:', messageId, priority);
    }

    function archiveMessage(messageId) {
      if (confirm('Are you sure you want to archive this message?')) {
        // Implement archive functionality
        console.log('Archiving message:', messageId);
      }
    }

    function confirmDelete(messageId, subject) {
      document.getElementById('deleteMessageSubject').textContent = subject;
      document.getElementById('deleteForm').action = `/admin/contacts/${messageId}`;
      new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    function bulkMarkAsRead() {
      const selected = document.querySelectorAll('.contact-checkbox:checked');
      if (selected.length === 0) {
        alert('Please select messages to mark as read.');
        return;
      }

      if (confirm(`Are you sure you want to mark ${selected.length} message(s) as read?`)) {
        // Implement bulk mark as read functionality
        console.log('Bulk marking as read:', Array.from(selected).map(cb => cb.value));
      }
    }

    // Select all functionality
    document.getElementById('selectAll').addEventListener('change', function() {
      const checkboxes = document.querySelectorAll('.contact-checkbox');
      checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 5000);
  </script>
@endpush
