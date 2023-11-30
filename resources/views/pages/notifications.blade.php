@extends('layouts.app')

@section('sytle')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link href="{{ asset('css/cnotification.css') }}" rel="stylesheet">
@section('content')

    <div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="{{'/tags'}}">Tags</a>
    <a class="active" href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    </div>

    <div class="container">
    <div class="row">
        <div class="col-lg-9 right">
            <div class="box shadow-sm rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Recent</h6>
                </div>
                <div class="box-body p-0">
                    <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://ontent/avatar/avatar3.png" alt="" />
                        </div>
                        <div class="font-weight-bold mr-3">
                            <div class="text-truncate">DAILY RUNDOWN: WEDNESDAY</div>
                            <div class="small">Income tax sops on the cards, The bias in VC funding, and other top news for you</div>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">3d</div>
                        </span>
                    </div>
                    <div class="p-3 d-flex align-items-center osahan-post-header">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://ar" alt="" />
                        </div>
                        <div class="font-weight-bold mr-3">
                            <div class="mb-2">We found a job at askbootstrap Ltd that you may be interested in Vivamus imperdiet venenatis est...</div>
                            <button type="button" class="btn btn-outline-success btn-sm">View Jobs</button>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">4d</div>
                        </span>
                    </div>
                </div>
            </div>
            <div class="box shadow-sm rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Earlier</h6>
                </div>
                <div class="box-body p-0">
                    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3 d-flex align-items-center bg-danger justify-content-center rounded-circle text-white">DRM</div>
                        <div class="font-weight-bold mr-3">
                            <div class="text-truncate">DAILY RUNDOWN: MONDAY</div>
                            <div class="small">Nunc purus metus, aliquam vitae venenatis sit amet, porta non est.</div>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" style="">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">3d</div>
                        </span>
                    </div>
                    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="https://bootdeyavatar/avatar3.png" alt="" /></div>
                        <div class="font-weight-bold mr-3">
                            <div class="text-truncate">DAILY RUNDOWN: SATURDAY</div>
                            <div class="small">Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper</div>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">3d</div>
                        </span>
                    </div>
                    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://bootdey.comg" alt="" />
                        </div>
                        <div class="font-weight-bold mr-3">
                            <div class="mb-2"><span class="font-weight-normal">Congratulate Gurdeep Singh Osahan (iamgurdeeposahan)</span> for 5 years at Askbootsrap Pvt.</div>
                            <button type="button" class="btn btn-outline-success btn-sm">Say congrats</button>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">4d</div>
                        </span>
                    </div>
                    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://bootdey.r/avatar4.png" alt="" />
                        </div>
                        <div class="font-weight-bold mr-3">
                            <div>
                                <span class="font-weight-normal">Congratulate Mnadeep singh (iamgurdeeposahan)</span> for 4 years at Askbootsrap Pvt.
                                <div class="small text-success"><i class="fa fa-check-circle"></i> You sent Mandeep a message</div>
                            </div>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">4d</div>
                        </span>
                    </div>
                    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3 d-flex align-items-center bg-success justify-content-center rounded-circle text-white">M</div>
                        <div class="font-weight-bold mr-3">
                            <div class="text-truncate">DAILY RUNDOWN: MONDAY</div>
                            <div class="small">Nunc purus metus, aliquam vitae venenatis sit amet, porta non est.</div>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">3d</div>
                        </span>
                    </div>
                    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="https://bootatar/avatar3.png" alt="" /></div>
                        <div class="font-weight-bold mr-3">
                            <div class="text-truncate">DAILY RUNDOWN: SATURDAY</div>
                            <div class="small">Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper</div>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">3d</div>
                        </span>
                    </div>
                    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://bootdey.com/png" alt="" />
                        </div>
                        <div class="font-weight-bold mr-3">
                            <div class="mb-2"><span class="font-weight-normal">Congratulate Gurdeep Singh Osahan (iamgurdeeposahan)</span> for 5 years at Askbootsrap Pvt.</div>
                            <button type="button" class="btn btn-outline-success btn-sm">Say congrats</button>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">4d</div>
                        </span>
                    </div>
                    <div class="p-3 d-flex align-items-center osahan-post-header">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://bootdeyatar2.png" alt="" />
                        </div>
                        <div class="font-weight-bold mr-3">
                            <div>
                                <span class="font-weight-normal">Congratulate Mnadeep singh (iamgurdeeposahan)</span> for 4 years at Askbootsrap Pvt.
                                <div class="small text-success"><i class="fa fa-check-circle"></i> You sent Mandeep a message</div>
                            </div>
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                </div>
                            </div>
                            <br />
                            <div class="text-right text-muted pt-1">4d</div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php /*
    <div style="color:white; font-size:0.0001em;">Home</div>
    <section id="notifications">
        @each('partials.notification', $notifications, 'notification')

    </section> */?>
@endsection