@extends('includes.app')
@section('title', 'Dashboard | Category')
@section('aditionalCss')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Menu
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="box-tools pull-right" style="position: inherit;">
                            <button type="button" onclick="showForm()" class="btn bg-navy ">Add New</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Menu Name</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menuitems as $key=> $menuitem)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $menuitem->name }}</td>
                                    <td><img style="max-width:150px;"  src="{{ URL::to('/') }}/assets/uploads/images/{{ $menuitem->main_image }}" ></td>
                                    <td>{{ $menuitem->price }}</td>
                                    <td>{{ $menuitem->qty }}</td>
                                    <td class="text-center">
                                        @if ($menuitem->status == 1)
                                        <small class="label  bg-green">Active</small>
                                        @elseif ($menuitem->status == 0)
                                        <small class="label  bg-yellow">Inactive</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" onclick="getData({{$menuitem->id}})"
                                            class="btn  btn-info btn-xs ">Edit/ View</button>

                                            @if ($menuitem->status == 1)
                                                <button type="button" onclick="toggleStatus(this)" data-status="0"  data-id="{{$menuitem->id}}"  class="btn  btn-warning btn-xs ">Inactivate</button>
                                            @elseif ($menuitem->status ==  0)
                                                <button type="button"  onclick="toggleStatus(this)" data-status="1"  data-id="{{$menuitem->id}}"  class="btn  btn-success btn-xs ">Activate</button>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach

                            
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        

                        </div>

                </div>
            </div>
        </div>
        <div class="modal imagecrop fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Image cropper</h5>
                </div>
                <div class="modal-body">
                <div class="img-cotainer">
                    <div class="row">
                    <div class="col-md-11">
                        <img src="" class='getimg' id='image'>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection
@include('menu.menu')
@section('aditionalJs')
  <script type="text/javascript">

var menuoption = <?php echo json_encode($menuoptioncategories); ?>;

    $( document ).ready(function() {
        changeOption(0);
    });
    
    var array = [];
    // start use for request js
    baseUrl           = "{{url("menu-item")}}";
    url               = baseUrl;
    primaryKey        = "id"; // use to set update url
    reloadAfterSubmit = true;
    formId = "menuItemForm";
    // end use for request js
    function showForm() {
        resetForm("menuItemForm");
        $( "#item-table" ).html('');
        $('#addModal').modal('show')

    }

    $('.table').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });

    function GetResultHandler(data) { // overiding ajax request js function
        if (data.hasOwnProperty('errors')) {
            oops();
        } else if (data.hasOwnProperty('success') && data.success == "19199212") {
            resetForm("menuItemForm");
            Object.keys(data.data).forEach(function(key) {
            $('input[name="name"]').val(data.data["name"]);
            $('input[name="price"]').val(data.data["price"]);
            $('input[name="qty"]').val(data.data["qty"]);
            $('input[name="id"]').val(data.data["id"]);

            $('#menu_category').val(data.data["menu_category"]); 
            $('#menu_category').trigger('change');

            });
            $( "#item-table" ).html('');
            $.each(data.data["menu_iitem_menu_option_category_menu_option"], function( key, value ) {
                if(value.menu_option_category_menu_option){
                    array.push(value.menu_option_category_menu_option.id);
                    $( "#item-table" ).append( $( '<tr><td><input type="hidden" class="hidden"  name="options[]" value='+value.menu_option_category_menu_option.id+'>'+value.menu_option_category_menu_option.menu_option_category.name+'</td><td>'+value.menu_option_category_menu_option.menu_option.name+'</td><td><button type="button" onclick="removeOption(this)" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></td></tr>' ) );
                }          
            });
            $('#addModal').modal('show');
        }
    }


    $('#menu_categories').change(function(){
        var index = $(this).children('option:selected').data('index');
        changeOption(index);     
    });

    /*
    |--------------------------------------------------------------------------
    |Change Options
    |--------------------------------------------------------------------------
    */

    function changeOption(index){
      
        var item = menuoption[index].category_menuoption;

        var childCategoriesDdl = $('#menu_options');
            childCategoriesDdl.empty();

        $.each(item, function(index, childCategory) {

            childCategoriesDdl.append(
         
                $('<option/>', {
                    value: childCategory.menu_option.id, 
                    text: childCategory.menu_option.name
                })
            );
        });

    }
    
    /*
    |--------------------------------------------------------------------------
    |Add options
    |--------------------------------------------------------------------------
    */
    function addOption(){
        var index = $('#menu_categories').children('option:selected').data('index');
        var data  = menuoption[index].category_menuoption;

        var  val1  = $('#menu_categories').val();
        var  val2  = $('#menu_options').val();
        var text1  = $( "#menu_categories option:selected" ).text();
        var text2  = $( "#menu_options option:selected" ).text()

        function findIndexInData(data, property, value, property2, value2) {
            var result = -1;
            data.some(function (item, i) {
                if (item[property] == value && item[property2] == value2 ) {
                    result = i;
                    return true;
                }
            });
            return result;
        }

       var index = findIndexInData(data, 'menu_option_category_id', val1,'menu_option_id',val2); // shows index of

       if ($.inArray(data[index].id, array) != -1){
         return;
       }

       array.push(data[index].id);

       $( "#item-table" ).append( $( '<tr><td><input type="hidden" class="hidden"  name="options[]" value='+data[index].id+'>'+text1+'</td><td>'+text2+'</td><td><button type="button" onclick="removeOption(this)" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></td></tr>' ) );

    };

    /*
    |--------------------------------------------------------------------------
    |Remove Options
    |--------------------------------------------------------------------------
    */
    function removeOption(ele){
        var element        =  $(ele).closest('tr');
        let remove_value   =  parseInt(element.find('.hidden').val());    
        var index          =  array.indexOf(remove_value);

        if (index !== -1) {
          array.splice(index, 1);
        }

        $(element).remove();
           
    }

    function toggleStatus(ele) {
        if(confirm("Are you sure ?")){
            var id     = $(ele).data("id");
            var status = $(ele).data("status");
            var xhttp;
            if (window.XMLHttpRequest) {
                 xhttp = new XMLHttpRequest();
            } else {
            // code for IE6, IE5
                 xhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xhttp.addEventListener("load", function() {
                data = JSON.parse(this.responseText);
                if (data.hasOwnProperty('errors')) {
                    oops();
                } else if (data.hasOwnProperty('success') && data.success == "19199212") {
                    window.location.reload();
                }

            });
            xhttp.addEventListener("error", function() {
                oops();
            });

            xhttp.open("POST", baseUrl +"/"+id+"/"+status, false);
            xhttp.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            xhttp.send();
        }
    }


    /*
    |--------------------------------------------------------------------------
    |Image cropper function
    |--------------------------------------------------------------------------
    */     
    var  $model = $('.imagecrop');
    var  $image = document.getElementById('image');
    var  cropper;


    $(document).on('change', '#imageUpload', function(e) {

      var files = e.target.files;

      var done = function(url){
        $image.src = url;
        $model.modal('show');
      }

      var reader;
      var file;
      var url;

      if(files && files.length>0){
          console.log('true');
          file = files[0];
          if(URL){
            done(URL.createObjectURL(file));
          }else if(FileReader){
            reader =  new FileReade();
            reder.onload = function(e){
              done(reader.result);
            }
            reader.readAsDataURL(file);
          }
      }
     
    });

    $model.on('shown.bs.modal', function(){
      cropper = new Cropper($image,{
        aspectRatio: 1,
        viewMode:1,
      });
    }).on('hidden.bs.modal', function(){
        if($( "#64baseimage" ).val()==""){
            $( "#imageUpload" ).val(null);
        }
        cropper.destroy(),
        cropper = null;
    });


    $(document).on('click', '#crop', function() {
        canvas = cropper.getCroppedCanvas({
          width:160,
          height:160,
        });

        canvas.toBlob(function(blob){
          url = URL.createObjectURL(blob);
          reader = new FileReader();
          reader.readAsDataURL(blob);
          reader.onload = function(e){
              var base64data = reader.result;
              $('#64baseimage').val(base64data);
              $model.modal('hide');
          }

        });

    }); 
  </script>
@endsection
