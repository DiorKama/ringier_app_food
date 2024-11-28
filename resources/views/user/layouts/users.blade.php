<x-monheader>
 </x-monheader>

 @include('user.layouts.partials.topnavUser')

    <div class="row container ml-3">
        <!-- Sidebar -->

        <div class="col-md-1"></div>
        
        {{$slot}}
          
    </div> 

    @include('user.layouts.partials.footerUser')

<x-monbody>
 </x-monbody>
