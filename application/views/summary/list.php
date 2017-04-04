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
        <div class="clearfix" style="float: right;">
          <a href="<?php echo base_url()?>summary/"><button class="btn btn-default">Summary All</button></a>
          <button class="btn btn-default">Summary Program List</button>
        </div>
    </div>
<div class="wrapper">
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
                    <table id="filter-value-table-primary" class="table text-center" style="display: none;">
                        <thead>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Presentase</th>
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
                <div class="panel-body">
                    <div class="clearfix col-sm-6" id="filter-value-table-program" style="display: none;">
                        <!-- isi disini -->
                    </div>
                    <div class="clearfix col-sm-6" id="filter-value-table-initiative" style="display: none;">
                        <!-- isi disini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(function() {
        $('#filter-value-table-primary').DataTable( {
            // "order": [[ 1, "asc" ]],
            "paging":   false,
            "info":   false,
            "searching":   false,
        } );

        // list filter
        $('#filter-select').on('change', function() {
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
                    var newRowContent = '<tr><td><a class="filter-value-detail-program" data-nama="'+$text_nama+'" data-role="pmo_head" >'+$text_nama+'</a></td><td>'+$total_initiative+'</td><td>'+$text_presentase+' %</td></tr>';
                    $(newRowContent).appendTo($("#filter-value-table-primary-body"));
                <?php endforeach ?>
            }
            // else if(this.value == '2'){
            //     $('#filter-value-title').text('CO - PMO');
            //     $("#filter-value-table-primary-body").empty();
            //     $('#filter-value-table-primary').show();

            //     <?php //foreach ($co_pmo_list as $key => $value): ?>
            //         $i++;
            //         $text_nama = <?php //echo json_encode($value['nama']); ?>;
            //         $text_presentase = <?php //echo json_encode($value['total_completed']); ?>;
            //         var newRowContent = '<tr><td><a class="filter-value-detail-cpmo" data-nama="'+$text_nama+'" >'+$text_nama+'</a></td><td>'+$text_presentase+' %</td></tr>';
            //         $(newRowContent).appendTo($("#filter-value-table-primary-body"));
            //     <?php //endforeach ?>
            // }
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
                    var newRowContent = '<tr><td><a class="filter-value-detail-program" data-nama="'+$text_nama+'" data-role="dir_spon" >'+$text_nama+'</a></td><td>'+$total_initiative+'</td><td>'+$text_presentase+' %</td></tr>';
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

                    $('#nama-detail').text($nama);
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
</script>