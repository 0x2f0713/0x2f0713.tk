@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    @if (null !== session('info'))
                        <div class="alert alert-info" role="alert">{{ session('info') }}
                        </div>
                    @endif
                    @if (null !== session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}
                        </div>
                    @endif
                    @if (null !== session('danger'))
                        <div class="alert alert-danger" role="alert">{{ session('danger') }}
                        </div>
                    @endif
                    <div class="card">
                        <form class="form-horizontal" action="wifi/store" method="post" enctype="multipart/form-data">
                            <div class="card-header"><strong>Basic Form</strong> Elements</div>
                            <div class="card-body">

                                <div class="form-group row">
                                    @csrf
                                    <label class="col-md-3 col-form-label" for="textarea-input">Raw data</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="textarea-input" name="data" rows="9"
                                            placeholder="Content.."></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="data_type">Select</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="data_type" name="data_type">
                                            <option value="0">Cracked WiFi</option>
                                            <option value="1">Hash (22000)</option>
                                            <option value="2">Hash (16800)</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset"> Reset</button>
                                <a href="wifi/destroyDuplicatePasswordFoundNoHash">
                                    <button class="btn btn-sm btn-danger" type="button">destroyDuplicatePasswordFoundNoHash</button>
                                </a>
                                <a href="wifi/destroyDuplicatePasswordFoundHaveHash">
                                    <button class="btn btn-sm btn-danger" type="button">destroyDuplicatePasswordFoundHaveHash</button>
                                </a>
                                <a href="wifi/destroyDuplicateHash">
                                    <button class="btn btn-sm btn-danger" type="button">destroyDuplicateHash</button>
                                </a>
                                <a href="wifi/export_cracked">
                                    <button class="btn btn-sm btn-success" type="button">Export cracked to .potfile</button>
                                </a>
                                <a href="wifi/export_passwd">
                                    <button class="btn btn-sm btn-success" type="button">Export password to .txt</button>
                                </a>
                                <a href="wifi/export_hashes">
                                    <button class="btn btn-sm btn-success" type="button">Export hashes to .22000</button>
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header"><i class="fa fa-align-justify"></i> Combined All Table</div>
                                <div class="card-body">
                                    <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Uploaded at</th>
                                                <th>AP MAC</th>
                                                <th>CLIENT MAC</th>
                                                <th>SSID</th>
                                                <th>HASH TYPE</th>
                                                <th>PASSWORD</th>
                                                <th>HASH</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($wifis as $wifi)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $wifi->created_at, 'UTC')->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y') }}</td>
                                                    <td>{{ $wifi->ap_mac }}</td>
                                                    <td>{{ $wifi->client_mac }}</td>
                                                    <td>{{ $wifi->ssid }}</td>

                                                    @switch($wifi->type)
                                                        @case(0)
                                                        <td><span class="badge badge-success">CRACKED</span></td>
                                                        @break
                                                        @case(1)
                                                        <td><span class="badge badge-danger">PMKID</span></td>
                                                        @break
                                                        @default
                                                        <td><span class="badge badge-danger">WPA2</span></td>
                                                    @endswitch

                                                    <td>{{ $wifi->password }}</td>
                                                    <td>{{ $wifi->hash }}</td>
                                                </tr>
                                            @empty
                                                <p>No WiFi</p>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row-->
                </div>
            </div>

        @endsection

    @section('javascript')

    @endsection
