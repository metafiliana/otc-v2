<style>
    .pmo_header{
        margin-right:40px;
    }
    .pmo_header_active a{
        margin-right:40px;
        color: black;
    }
    .wrapper {
        margin: 15px 50px 5px 50px;
    }
    /*.konten {
        margin :10px 20px 5px 20px;
        padding: 10px auto;
    }*/
    .well {
        margin: 25px;
    }
</style>
    <div class="row well">
        <a onclick="take('list')" class="btn btn-info-new "><span class="glyphicon glyphicon-print"></span> Print Kuantitatif</a>
        <div class="clearfix" style="float: right;">
          <a href="<?php echo base_url()?>summary/"><button class="btn btn-default">Summary All</button></a>
          <button class="btn btn-info" disabled="disabled">Summary Detail</button>
        </div>
    </div>
<div class="wrapper" id='list'>
<div class="component_part">
    <div class="row">
        <div class="col-md-12">
            <h3>List Summary</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <select id="filter-select">
                <option>- Filter -</option>
                <option value="1">PMO Head</option>
                <option value="2">CO-PMO</option>
                <option value="3">Direktur Sponsor</option>
                <option value="4">Initiative</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 id="filter-value-title" class="panel-title">Filter</h4>
                </div>
                <div class="panel-body">
                    <table id="filter-value-table-primary" class="table text-center display" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th id="kualitatifPercent"><a>Kualitatif</a></th>
                                <th id="kuantitatifPercent"><a>Kuantitatif</a></th>
                            </tr>
                        </thead>
                        <tbody id="filter-value-table-primary-body">
                            <!-- isi disini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Detail : <span id="nama-detail"></span></h4>
                </div>
                <div class="panel-body" id="wrap-panel-initiative">
                    <div class="clearfix col-sm-6" id="filter-value-table-program" style="display: none;">
                        <!-- isi disini -->
                    </div>
                    <div class="clearfix col-sm-6" id="filter-value-table-initiative" style="display: none;">
                        <!-- isi disini -->
                    </div>
                </div>
                <div class="panel-body" id="wrap-panel-kuantitatif">
                    <div class="clearfix col-sm-12" id="filter-value-table-kuantitatif" style="display: block;">
                        <!-- isi disini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="<?php echo base_url();?>assets/js/jquery.sortElements.js"></script>
<script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $(function() {
        // $('#filter-value-table-primary').DataTable( {
        //     // "order": [[ 1, "asc" ]],
        //     "paging":   false,
        //     "info":   false,
        //     "searching":   false,
        // } );

        // list filter
        $('#filter-select').on('change', function() {
            $('#wrap-panel-kuantitatif').hide();
            $i = 0;
            if (this.value == '1') {
                $('#filter-value-title').text('PMO Head');
                $('#nama-detail').html('');
                $("#filter-value-table-primary-body").empty();

                $('#filter-value-table-program').empty();
                $('#filter-value-table-initiative').empty();
                $('#filter-value-table-workblock').empty();
                
                $('#filter-value-table-primary').show();

                <?php foreach ($pmo_head_list as $key => $value): ?>
                    $i++;
                    $text_nama = <?php echo json_encode($value['nama']); ?>;
                    $total_initiative = <?php echo json_encode($value['total_initiative']); ?>;
                    $text_presentase = <?php echo json_encode($value['total_completed']); ?>;
                    $text_kuantitative = <?php echo json_encode($value['total_kuantitatif']); ?>;
                    $inits = <?php echo json_encode($value['initiative']); ?>;
                    var newRowContent = '<tr><td>'+$text_nama+'</td><td>'+$total_initiative+'</td><td><a class="filter-value-detail-program" data-nama="'+$text_nama+'" data-role="pmo_head" >'+$text_presentase+' %</a></td><td><a class="filter-value-detail-kuantitatif" data-init="'+$inits+'" data-nama="'+$text_nama+'">'+$text_kuantitative+' %</a></td></tr>';
                    $(newRowContent).appendTo($("#filter-value-table-primary-body"));
                <?php endforeach ?>
            }
            else if(this.value == '2'){
                $('#filter-value-title').text('CO PMO');
                $("#filter-value-table-primary-body").empty();
                $('#filter-value-table-program').empty();
                $('#filter-value-table-initiative').empty();
                $('#filter-value-table-workblock').empty();
                $('#nama-detail').text('');
                $('#filter-value-table-primary').show();

                <?php foreach ($co_pmo_list as $key => $value): ?>
                    $i++;
                    $text_nama = <?php echo json_encode($value['nama']); ?>;
                    $total_initiative = <?php echo json_encode($value['total_initiative']); ?>;
                    $text_presentase = <?php echo json_encode($value['total_completed']); ?>;
                    $text_kuantitative = <?php echo json_encode($value['total_kuantitatif']); ?>;
                    $inits = <?php echo json_encode($value['initiative_string']); ?>;
                    var newRowContent = '<tr><td>'+$text_nama+'</td><td>'+$total_initiative+'</td><td><a class="filter-value-detail-program" data-nama="'+$text_nama+'" data-role="co_pmo" >'+$text_presentase+' %</a></td><td><a class="filter-value-detail-kuantitatif" data-init="'+$inits+'" data-nama="'+$text_nama+'">'+$text_kuantitative+' %</a></td></tr>';
                    $(newRowContent).appendTo($("#filter-value-table-primary-body"));
                <?php endforeach ?>
            }
            else if(this.value == '3'){
                $('#filter-value-title').text('Direktur Sponsor');
                $("#filter-value-table-primary-body").empty();
                $('#filter-value-table-program').empty();
                $('#filter-value-table-initiative').empty();
                $('#filter-value-table-workblock').empty();
                $('#nama-detail').text('');
                $('#filter-value-table-primary').show();

                <?php foreach ($dir_spon_list as $key => $value): ?>
                    $i++;
                    $text_nama = <?php echo json_encode($value['nama']); ?>;
                    $total_initiative = <?php echo json_encode($value['total_initiative']); ?>;
                    $text_presentase = <?php echo json_encode($value['total_completed']); ?>;
                    $text_kuantitative = <?php echo json_encode($value['total_kuantitatif']); ?>;
                    $inits = <?php echo json_encode($value['initiative']); ?>;
                    var newRowContent = '<tr><td>'+$text_nama+'</td><td>'+$total_initiative+'</td><td><a class="filter-value-detail-program" data-nama="'+$text_nama+'" data-role="dir_spon" >'+$text_presentase+' %</a></td><td><a class="filter-value-detail-kuantitatif" data-init="'+$inits+'" data-nama="'+$text_nama+'">'+$text_kuantitative+' %</a></td></tr>';
                    $(newRowContent).appendTo($("#filter-value-table-primary-body"));
                <?php endforeach ?>
            }
            else if(this.value == '4'){
                $('#filter-value-title').text('Initiative');
                $("#filter-value-table-primary-body").empty();
                $('#filter-value-table-program').empty();
                $('#filter-value-table-initiative').empty();
                $('#filter-value-table-workblock').empty();
                $('#nama-detail').text('');
                $('#filter-value-table-primary').show();

                <?php foreach ($initiative_list as $key => $value): ?>
                    $i++;
                    $text_nama = <?php echo json_encode($value['nama']); ?>;
                    $total_initiative = <?php echo json_encode($value['total_initiative']); ?>;
                    $text_presentase = <?php echo json_encode($value['total_completed']); ?>;
                    $text_kuantitative = <?php echo json_encode($value['total_kuantitatif']); ?>;
                    var newRowContent = '<tr><td>Initiative '+$text_nama+'</td><td>'+$total_initiative+'</td><td><a class="filter-value-detail-program" data-nama="'+$text_nama+'" data-role="initiatives" >'+$text_presentase+' %</a></td><td><a class="filter-value-detail-kuantitatif" data-init="'+$text_nama+'" data-nama="'+$text_nama+'">'+$text_kuantitative+' %</a></td></tr>';
                    $(newRowContent).appendTo($("#filter-value-table-primary-body"));
                <?php endforeach ?>
            }
        });

    });

    //untuk trigger detail head pmo
    $(document).on("click",".filter-value-detail-program",function(event){
        $nama = $(this).data('nama');
        $role = $(this).data('role');

        $.ajax({
            type: "GET",
            url: config.base+"summary/listDetailProgram",
            data: {nama:$nama,role:$role},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $('#filter-value-table-program').empty();
                    $('#filter-value-table-initiative').empty();
                    $('#filter-value-table-workblock').empty();
                    $('#nama-detail').text('');

                    $('#nama-detail').text('Initiative '+$nama);
                    $('#wrap-panel-kuantitatif').hide();
                    $('#wrap-panel-initiative').show();
                    $('#filter-value-table-program').show();
                    $('#filter-value-table-program').html(resp.html);
                   // $('#wb_count').html(resp.wb);
                   // $('#count_completed').html(resp.completed);

                }else{}
            }
        });
    });

    $(document).on("click",".filter-value-detail-program-list",function(event){
        $id = $(this).data('id');

        $.ajax({
            type: "GET",
            url: config.base+"summary/getDetailProgram/",
            data: {id:$id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $('#filter-value-table-initiative').empty();
                    // $('#filter-value-table-workblock').show();
                    // $(this).css('font-weight', 'bold');
                    $('#panel-program-'+$id).html(resp.detail_programs);

                }else{}
            }
        });
    });

    //untuk trigger detail co pmo
    $(document).on("click",".filter-value-detail-initiative",function(event){
        $id = $(this).data('id');
        $initcode = $(this).data('initcode');

        $.ajax({
            type: "GET",
            url: config.base+"summary/listDetailInitiative",
            data: {id:$id,initcode:$initcode},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $('#filter-value-table-initiative').empty();
                    $('#filter-value-table-workblock').empty();

                    $('#filter-value-table-initiative').show();
                    $('#filter-value-table-initiative').html(resp.html);
                   // $('#wb_count').html(resp.wb);
                   // $('#count_completed').html(resp.completed);

                }else{}
            }
        });
    });

    //untuk trigger detail direktur sponsor
    $(document).on("click",".filter-value-detail-workblock",function(event){
        $id = $(this).data('id');

        $.ajax({
            type: "GET",
            url: config.base+"summary/listDetailWorkblock/",
            data: {id:$id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    // $('#filter-value-table-workblock').empty();
                    // $('#filter-value-table-workblock').show();
                    $('#panel-initiative-'+$id).html(resp.workblocks_list);

                }else{}
            }
        });
    });

    $(document).on("click",".filter-value-detail-kuantitatif",function(event){
        $init = $(this).data('init');
        $nama = $(this).data('nama');

        $.ajax({
            type: "GET",
            url: config.base+"summary/listDetailKuantitatif",
            data: {init:$init},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $('#filter-value-table-program').empty();
                    $('#filter-value-table-initiative').empty();
                    $('#filter-value-table-workblock').empty();
                    $('#nama-detail').text('');

                    $('#nama-detail').text('Kuantitatif '+$nama);
                    $('#wrap-panel-initiative').hide();
                    $('#wrap-panel-kuantitatif').show();
                    $('#filter-value-table-kuantitatif').html(resp.html);
                }
            }
        });
    });

    var table = $('#filter-value-table-primary');
    
    $('#kualitatifPercent, #kuantitatifPercent')
        .wrapInner('<span title="sort this column"/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            });
        });

function take(div) {
// First render all SVGs to canvases
var svgElements= $("#"+div).find('svg');

//replace all svgs with a temp canvas
svgElements.each(function () {
 var canvas, xml;

 canvas = document.createElement("canvas");
 canvas.className = "screenShotTempCanvas";
 //convert SVG into a XML string
 xml = (new XMLSerializer()).serializeToString(this);

 // Removing the name space as IE throws an error
 xml = xml.replace(/xmlns=\"http:\/\/www\.w3\.org\/2000\/svg\"/, '');

 //draw the SVG onto a canvas
 canvg(canvas, xml);
 $(canvas).insertAfter(this);
 //hide the SVG element
 this.className = "tempHide";
 $(this).hide();
});

html2canvas($("#"+div), {
     allowTaint: true,
     onrendered: function (canvas) {
         var myImage = canvas.toDataURL("image/pdf");
         var tWindow = window.open(""); 
         $(tWindow.document.body).html("<img id='Image' src=" + myImage + " style='width:100%;'></img>").ready(function () {
             tWindow.focus();
             tWindow.print();
         });
     }
});
//location.reload();
}     
</script>