<div class="card-body">
    @include('partials.feedbacks.alert')
    <form class="validate-form mt-1" method="GET" action="" id="filter-form">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="account-user">Select user</label>
                    <select class="select2 form-control" id="account-user" name="user" onchange="document.getElementById('filter-form').submit();">
                        <option value="all"
                                {{ (old('user') ?? $selected_user) == "all" ? 'selected' : '' }}>
                            All users
                        </option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                    {{ (old('user') ?? $selected_user) == $user->id ? 'selected' : '' }}>
                                {{ $user->id === auth()->user()->id ? 'Me' : $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>