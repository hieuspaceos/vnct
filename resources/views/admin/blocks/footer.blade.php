<!-- jQuery -->

<meta name="csrf-token" content="{{ csrf_token() }}">



<script src="/template/admin/plugins/jquery/jquery.min.js"></script>

<script src="/template/admin/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Bootstrap 4 -->

<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->

<script src="/template/admin/dist/js/adminlte.min.js"></script>

<script type="text/javascript" src="/datatables/js/jquery.dataTables.js">    </script>

<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>



<script type="text/javascript" src="/template/admin/js/function.js"></script>

<script type="text/javascript" src="/template/admin/js/jquery.nestable.js"></script>

<script type="text/javascript" src="/template/admin/js/select2.min.js"></script>

<script type="text/javascript">

		$('#dataTables').DataTable({

                responsive: true,				

				"order": [[ 0, "desc" ]],

				

				

        });

		$('#dataTables-order').DataTable({

                responsive: true,				

				"order": [[ 0, "desc" ]],

				initComplete: function () {

                this.api().columns('.select-filter').every( function () {

                    var column = this;

                    var select = $('<select><option value="">Lọc theo danh mục</option></select>')

                        .appendTo( $(column.footer()).empty() )

                        .on( 'change', function () {

                            var val = $.fn.dataTable.util.escapeRegex(

                                $(this).val()

                            );



                        column

                            .search( val ? '^'+val+'$' : '', true, false )

                            .draw();

                    } );



                column.data().unique().sort().each( function ( d, j ) {

                   select.append( '<option value="'+d+'">'+d+'</option>' )

                } );

                } );

            }

        });

        $(document).on('click','.del-imageDD',function(){

			$('#avatar').val('');

			$(this).parent().next('img').attr('src','/template/admin/image/noimage.jpg');

		})

        $.ajaxSetup({

            headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

        function format_money(money) {

    

if (money == 0) {

            return 0;

        }

        var tmp = money.toString().split('').reverse().join('');

        var a = [];

        var len = tmp.length;

        var b = true;

        while (b) {

            if (tmp.indexOf(",") > 0) {

                tmp = tmp.replace(",", "");

                b = true;

            }

            else {

                b = false;

            }

        }

        b = true;

        while (b) {

            len = tmp.length;

            if (len % 3 != 0) {

                tmp = tmp.toString() + '0';

                b = true;

            }

            else {

                b = false;

            }

        }

        for (var i = 0; i < tmp.length; i += 3) {

            a.push(tmp[i] + tmp[i + 1] + tmp[i + 2]);

        }

        tmp = a.toString().split('').reverse().join('');

        b = true;

        while (b) {

            if (tmp[0] == 0 || tmp[0] == ',') {

                tmp = tmp.substr(1);

                b = true;

            }

            else {

                b = false;

            }

        }

        return tmp;

    }

	</script>

@yield('css')

@yield('js')
@include('ckfinder::setup')
</body>

</html>