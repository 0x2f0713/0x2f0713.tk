@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
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

                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset"> Reset</button>
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
                                                <th>AP MAC</th>
                                                {{-- <th>AP VENDOR</th> --}}
                                                <th>CLIENT MAC</th>
                                                <th>SSID</th>
                                                <th>PASSWORD</th>
                                                <th>HASH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                            <td>Vishnu Serghei</td>
                            <td>2012/01/01</td>
                            <td>Member</td>
                            <td><span class="badge badge-success">Active</span></td>
                          </tr> --}}
                                            @forelse ($wifis as $wifi)
                                            <tr>
                                                <td>{{ $wifi->ap_mac }}</td>
                                                {{-- <td>{{ $wifi->ap_vendor }}</td> --}}
                                                <td>{{ $wifi->client_mac }}</td>
                                                <td>{{ $wifi->ssid }}</td>
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
