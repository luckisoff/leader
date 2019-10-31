<div class="modal fade bs-example-modal-sm" id="payment_info" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel"><i class="mdi mdi-information text-danger fa-fw"></i>Payment</h4> </div>
            <div class="modal-body">
               <i class="fa fa-check-circle" style="color:green;"></i> &nbsp; Your payment is successfull.
            </div>
            <input type="hidden" name="" id="faculty_id">
            <div class="modal-footer" style="text-align: left;">
                <a href="{{ route('audition.view-audition') }}"  class="btn btn-danger green confirm" id="confirm"> Ok
                </a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
