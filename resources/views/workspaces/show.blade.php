@extends('layouts.app')

@section('content')
<div class="container">
    <div style="background-color: #1A1A2E; padding: 20px; border-radius: 10px;">
        <h1 style="color: #F9FAFB;">{{ $workspace->name }}</h1>
        <p class="card-text" style="color: #F9FAFB;"><strong>Idea:</strong> {{ $workspace->idea->project_idea }}</p>
        <p class="card-text" style="color: #F9FAFB;"><strong>Owner:</strong> {{ $workspace->user->name }}</p>
    </div>

    <!-- Uploaded Files Section -->
    <div class="card mb-4" style="background-color: #2A2A40; color: #F9FAFB; border: none; border-radius: 10px;">
        <div class="card-body">
            <h5 class="card-title">Uploaded Files</h5>
            @if ($files->isEmpty())
                <p>No files uploaded yet.</p>
            @else
                <ul class="list-group">
                    @foreach ($files as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            style="background-color: #1A1A2E;">
                            <span style="color: #F9FAFB;">{{ $file->original_name }}</span>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary btn-sm view-file"
                                        data-toggle="modal" data-target="#fileModal{{ $file->id }}"
                                        data-file-path="{{ asset('storage/' . $file->file_path) }}"
                                        style="background-color: #00ADB5; border-color: #00ADB5; width: 80px;">
                                    View
                                </button>
                                <a href="{{ route('workspaces.downloadFile', ['workspace' => $workspace->id, 'file' => $file->id]) }}"
                                   class="btn btn-success btn-sm"
                                   style="background-color: #6B5B95; border-color: #6B5B95; min-width: 80px;">Download</a>
                                <form action="{{ route('workspaces.deleteFile', ['workspace' => $workspace->id, 'file' => $file->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            style="background-color: #FF6F61; border-color: #FF6F61; min-width: 80px;">Delete</button>
                                </form>
                            </div>
                        </li>

                        <!-- Modal -->
                        <div class="modal fade" id="fileModal{{ $file->id }}" tabindex="-1" role="dialog"
                             aria-labelledby="fileModalLabel{{ $file->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content" style="background-color: #1A1A2E; color: #F9FAFB;">
                                    <div class="modal-header" style="border-bottom: none;">
                                        <h5 class="modal-title" id="fileModalLabel{{ $file->id }}"
                                            style="color: #F9FAFB;">{{ $file->original_name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true" style="color: #F9FAFB;">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if (Str::endsWith($file->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $file->file_path))) }}" class="img-fluid" alt="{{ $file->original_name }}">

                                        @elseif (Str::endsWith($file->file_path, ['.pdf']))
                                            <embed src="{{ asset('storage/' . $file->file_path) }}"
                                                   type="application/pdf" width="100%" height="600px"/>
                                        @elseif (Str::endsWith($file->file_path, ['.txt']))
                                            <iframe src="{{ asset('storage/' . $file->file_path) }}"
                                                    width="100%" height="600px"></iframe>
                                        @else
                                            <p>File type not supported for preview.</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer" style="border-top: none;">
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal" style="background-color: #00ADB5;">Close
                                        </button>
                                        <a href="{{ route('workspaces.downloadFile', ['workspace' => $workspace->id, 'file' => $file->id]) }}"
                                           class="btn btn-success btn-sm"
                                           style="background-color: #6B5B95; border-color: #6B5B95;">Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Upload New File Section -->
    <div class="card mb-4" style="background-color: #2A2A40; color: #F9FAFB; border: none; border-radius: 10px;">
        <div class="card-body">
            <h5 class="card-title">Upload New File</h5>
            <form action="{{ route('workspaces.uploadFile', $workspace->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file" style="color: #F9FAFB;">Choose File:</label>
                    <input type="file" class="form-control-file" id="file" name="file" required>
                </div>
                <button type="submit" class="btn btn-primary"
                        style="background-color: #00ADB5; border-color: #00ADB5;">Upload File
                </button>
            </form>
        </div>
    </div>

    <!-- Chat Section -->
    <div class="card" style="background-color: #2A2A40; color: #F9FAFB; border: none; border-radius: 10px;">
        <div class="card-body">
            <h5 class="card-title">Chats</h5>
            <div id="chat-messages" class="mb-3" style="height: 300px; overflow-y: auto; color:black">
                @if ($workspace->messages->isEmpty())
                    <p class="text-muted">No messages yet.</p>
                @else
                    @foreach ($workspace->messages as $message)
                        <div class="card mb-2">
                            <div class="card-body">
                                <p class="card-text"><strong>{{ $message->register->name }}:</strong> {{ $message->content }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <form id="chat-form" action="{{ route('workspaces.sendMessage', $workspace->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content" style="color: #F9FAFB;">Message:</label>
                    <textarea class="form-control" id="content" name="content" rows="3"
                              placeholder="Type your message here..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                        style="background-color: #00ADB5; border-color: #00ADB5;">Send
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Echo.channel('chat-room')
            .listen('.message.sent', (event) => {
                console.log('New message received:', event.message);
                $('#chat-messages').append(`<div class="card mb-2"><div class="card-body"><p class="card-text"><strong>${event.message.register.name}}:</strong> ${event.message.content}</p></div></div>`);
            });
    });
</script>
@endsection
