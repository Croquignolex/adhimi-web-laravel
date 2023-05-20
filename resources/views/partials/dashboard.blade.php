<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            @if(enums_equals($type, \App\Enums\DashboardScopeEnum::Global))
                <div class="card card-statistics">
                    <div class="mt-2 mx-2">
                        <h4>Statistics</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="media">
                                    <div class="avatar bg-light-success mr-2">
                                        <div class="avatar-content">
                                            <i data-feather="trending-up" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">{{ number_format($revenue) }}</h4>
                                        <p class="card-text font-small-3 mb-0">Revenue</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="media">
                                    <div class="avatar bg-light-warning mr-2">
                                        <div class="avatar-content">
                                            <i data-feather="users" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">{{ number_format($users) }}</h4>
                                        <p class="card-text font-small-3 mb-0">Users</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                <div class="media">
                                    <div class="avatar bg-light-info mr-2">
                                        <div class="avatar-content">
                                            <i data-feather="file" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">{{ number_format($invoices) }}</h4>
                                        <p class="card-text font-small-3 mb-0">Invoices</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="media">
                                    <div class="avatar bg-light-primary mr-2">
                                        <div class="avatar-content">
                                            <i data-feather="cpu" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">{{ number_format($requests) }}</h4>
                                        <p class="card-text font-small-3 mb-0">Requests</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="mt-2 mx-2">
                        <h4>Incomes</h4>
                        <button type="button" id="payments-selected-range" style="display: none"
                                data-range="{{ \App\Enums\DashboardRangeEnum::Daily }}"
                                class="btn btn-outline-primary btn-sm dropdown-toggle budget-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        >
                            Today
                        </button>
                        <div class="dropdown-menu">
                            <span class="dropdown-item payments-range" data-range="{{ \App\Enums\DashboardRangeEnum::Daily }}">Today</span>
                            <span class="dropdown-item payments-range" data-range="{{ \App\Enums\DashboardRangeEnum::Weekly }}">This week</span>
                            <span class="dropdown-item payments-range" data-range="{{ \App\Enums\DashboardRangeEnum::Monthly }}">This month</span>
                            <span class="dropdown-item payments-range" data-range="{{ \App\Enums\DashboardRangeEnum::Yearly }}">This year</span>
                        </div>
                        <div class="alert alert-danger fade show mt-1" role="alert" id="incomes-error-alert" style="display: none">
                            <div class="alert-body text-center">
                                Something when wrong, please contact he administrator
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4 class="font-weight-bold mb-25 text-warning" id="payments-amount" style="display: none">0</h4>
                        <h5 class="font-weight-bold mb-25 payments-loader">
                            <span class="spinner-border spinner-border-sm text-warning" role="status"></span>
                        </h5>
                    </div>
                    <div class="card-body text-center" style="height: 400px">
                        <span class="spinner-border text-primary payments-loader" role="status"></span>
                        <canvas id="payments-chart" data-url="{{ route('dashboard.global-incomes-data') }}" style="display: none"></canvas>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="mt-2 mx-2">
                    <h4>Requests</h4>
                    <button type="button" id="requests-selected-range" style="display: none"
                            data-range="{{ \App\Enums\DashboardRangeEnum::Daily }}"
                            class="btn btn-outline-primary btn-sm dropdown-toggle budget-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    >
                        Today
                    </button>
                    <div class="dropdown-menu">
                        <span class="dropdown-item requests-range" data-range="{{ \App\Enums\DashboardRangeEnum::Daily }}">Today</span>
                        <span class="dropdown-item requests-range" data-range="{{ \App\Enums\DashboardRangeEnum::Weekly }}">This week</span>
                        <span class="dropdown-item requests-range" data-range="{{ \App\Enums\DashboardRangeEnum::Monthly }}">This month</span>
                        <span class="dropdown-item requests-range" data-range="{{ \App\Enums\DashboardRangeEnum::Yearly }}">This year</span>
                    </div>
                    <div class="alert alert-danger fade show mt-1" role="alert" id="requests-error-alert" style="display: none">
                        <div class="alert-body text-center">
                            Something when wrong, please contact he administrator
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <div class="d-flex d-flex align-items-center mt-1 mt-sm-0">
                        <div class="mr-1">
                            <h5 class="font-weight-bold mb-25" id="successful-requests" style="display: none">0</h5>
                            <h5 class="font-weight-bold mb-25 requests-loader">
                                <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                            </h5>
                            <span class="bullet bullet-success bullet-sm align-middle cursor-pointer"></span>
                            <span class="align-middle cursor-pointer">Successful requests</span>
                        </div>
                        <div class="mr-1">
                            <h5 class="font-weight-bold mb-25" id="failed-requests" style="display: none">0</h5>
                            <h5 class="font-weight-bold mb-25 requests-loader">
                                <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                            </h5>
                            <span class="bullet bullet-danger bullet-sm align-middle cursor-pointer"></span>
                            <span class="align-middle cursor-pointer">Failed requests</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated requests-loader" role="progressbar" style="width: 100%"></div>
                        <div class="progress-bar bg-success" role="progressbar" style="display: none" id="successful-requests-percentage"></div>
                        <div class="progress-bar bg-danger" role="progressbar" style="display: none" id="failed-requests-percentage"></div>
                    </div>
                </div>
                <div class="card-body text-center" style="height: 400px">
                    <span class="spinner-border text-primary requests-loader" role="status"></span>
                    <canvas id="requests-chart"
                            data-url="{{ route(enums_equals($type, \App\Enums\DashboardScopeEnum::Global) ? 'dashboard.global-requests-data' : 'dashboard.requests-data') }}"
                            style="display: none">
                    </canvas>
                </div>
            </div>
        </div>
    </div>
</div>