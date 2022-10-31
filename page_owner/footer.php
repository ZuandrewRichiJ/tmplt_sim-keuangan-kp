</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>&copy; <script>
          document.write(new Date().getFullYear());
        </script> Teknik Informatika -
        <b><a href="https://uir.ac.id/" target="_blank">Universitas Islam Riau</a></b>
      </span>
    </div>
  </div>
</footer>
<!-- Footer -->
</div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../assets/js/ruang-admin.min.js"></script>
<script src="../assets/vendor/chart.js/Chart.min.js"></script>

<script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="../assets/vendor/select2/dist/js/select2.min.js"></script>
<!-- Bootstrap Datepicker -->
<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Page level custom scripts -->
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable(); // ID From dataTable 
    $('#dataTableHover').DataTable(); // ID From dataTable with Hover
  });
</script>
<script>
  $(document).ready(function() {


    $('.select2-single').select2();

    // Select2 Single  with Placeholder
    $('.select2-single-placeholder').select2({
      placeholder: "Select a Province",
      allowClear: true
    });

    // Select2 Multiple
    $('.select2-multiple').select2();

    // Bootstrap Date Picker
    $('#simple-date1 .input-group.date').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: 'linked',
      todayHighlight: true,
      autoclose: true,
    });

    $('#simple-date2 .input-group.date').datepicker({
      startView: 1,
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayHighlight: true,
      todayBtn: 'linked',
    });

    $('#simple-date3 .input-group.date').datepicker({
      startView: 2,
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayHighlight: true,
      todayBtn: 'linked',
    });

    $('#simple-date4 .input-daterange').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      todayBtn: 'linked',
    });

    // TouchSpin

    $('#touchSpin1').TouchSpin({
      min: 0,
      max: 100,
      boostat: 5,
      maxboostedstep: 10,
      initval: 0
    });

    $('#touchSpin2').TouchSpin({
      min: 0,
      max: 100,
      decimals: 2,
      step: 0.1,
      postfix: '%',
      initval: 0,
      boostat: 5,
      maxboostedstep: 10
    });

    $('#touchSpin3').TouchSpin({
      min: 0,
      max: 100,
      initval: 0,
      boostat: 5,
      maxboostedstep: 10,
      verticalbuttons: true,
    });

    $('#clockPicker1').clockpicker({
      donetext: 'Done'
    });

    $('#clockPicker2').clockpicker({
      autoclose: true
    });

    let input = $('#clockPicker3').clockpicker({
      autoclose: true,
      'default': 'now',
      placement: 'top',
      align: 'left',
    });

    $('#check-minutes').click(function(e) {
      e.stopPropagation();
      input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });

  });
</script>
</body>

</html>