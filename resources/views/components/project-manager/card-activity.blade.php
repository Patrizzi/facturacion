<div class="mx-3">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Profile Detail</h5>
            <div class="ibox-tools">
                <a href="{{ route('project_managers.cards.create', 1) }}">
                    <i class="fa fa-plus"></i>
                </a>
                <a href="{{ route('project_managers.cards.edit', [1, 1]) }}">
                    <i class="fa fa-edit"></i>
                </a>
                <form action="{{ route('project_managers.cards.destroy', [1, 1]) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="border: none; background: none; cursor: pointer;">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        <div>
            <div class="ibox-content">
                <div class="mb-3">
                    <img alt="image" class="img-fluid" src="https://picsum.photos/1056/594.webp">
                </div>
                <div class="row mb-3">
                    <div class="col-sm">
                        <span class="label label-primary">Active</span>
                    </div>
                    <div class="col-sm">
                        <div class="progress progress-mini">
                            <div style="width: 48%;" class="progress-bar"></div>
                        </div>
                        {{-- <img src="http://localhost/profile/images/defecto_avatar.jpg" class="rounded-circle" alt="worker image"> --}}
                    </div>
                </div>
                <div class="project-title mb-2">
                    <a href="project_detail.html">Contract with Zender Company</a>
                    <br>
                    <small>Created 14.08.2014</small>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                    exercitat.
                </p>
                <div class="row">
                    <div class="col-sm">
                        <a href="#" class="btn btn-white btn-sm"><i class="fa fa-list-ul"></i> Tareas </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
