@extends('layout.main')
@section('content')
@section('title', 'Dashboard')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p>

        </p>
     
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <a style="color: inherit" href="{{ route('corpses') }}">
                    <div class="info-box">

                        <span class="info-box-icon bg-info">
                            <i class="fas fa-file-invoice"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">In Morgue</span>
                            <span class="info-box-number">{{ $in_morgue ?? 0 }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <a style="color: inherit" href="{{ route('racks') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-success">
                            <i class="fas fa-money-check"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Available Rack</span>
                            <span class="info-box-number">{{ $available_rack_count ?? 0 }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <a style="color: inherit" href="{{ route('racks') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-chalkboard-teacher"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Used Rack</span>
                            <span class="info-box-number"><sub>{{$used_rack_count?? 0}}</sub> </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <a style="color: inherit" href="{{ route('racks') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-chalkboard-teacher"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Rack</span>
                            <span class="info-box-number">{{ $rack_count?? 0 }} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <a style="color: inherit" href="{{ route('corpses') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-chalkboard-teacher"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">To be Collected</span>
                            <span class="info-box-number"><sub>{{ $to_be_collected?? 0 }} ({{ date('F Y') }})</sub> </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <a style="color: inherit" href="{{ route('corpses') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-chalkboard-teacher"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Due</span>
                            <span class="info-box-number"><sub>{{ $due?? 0 }}</sub> </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <a style="color: inherit" href="{{ route('corpses') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-money-check-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sales</span>
                            <span class="info-box-number"><sub>N{{ number_format($sales?? 0 , 2)}} ({{ date('F Y') }})</sub> </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->


            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <a style="color: inherit" href="{{ route('users') }}">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Users</span>
                            <span class="info-box-number">{{ $user_count ?? 0 }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
           <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Entries Per day</h3>
                    <a href="javascript:void(0);">View Report</a>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">{{ App\Models\Corpse::count() }}</span>
                        <span>Entries Over Time</span>
                    </p>
                    {{-- <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                            <i class="fas fa-arrow-up"></i> 12.5%
                        </span>
                        <span class="text-muted">Since last week</span>
                    </p> --}}
                </div>

                <div class="position-relative mb-4">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="visitors-chart" height="600" width="1029"
                        style="display: block; height: 200px; width: 343px;" class="chartjs-render-monitor"></canvas>
                </div>
                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> This month
                    </span>
                    <span>
                        <i class="fas fa-square text-gray"></i> Last month
                    </span>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->

  
<script>
    function showUpload() {
        if ($('#show_upload').attr('hidden')) {
            $('#show_upload').attr('hidden', false);
        } else {
            $('#show_upload').attr('hidden', true);

        }
    }
</script>
@endsection
