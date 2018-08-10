<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<script>
    $(document).ready(function () {
        document.checkout_confirmation.submit();
    });
</script>

<div>
    <form name="checkout_confirmation"
          action="{{$result['action']}}"
          method="post"
          target="secureframe">
        <input type="hidden" name="bill_name" value="{{$result['bill_name']}}">
        <input type="hidden" name="merchant_id" value="{{$result['merchant']}}">
        <input type="hidden" name="txn_type" value="{{$result['txn_type']}}">
        <input type="hidden" name="amount" value="{{$result['amount']}}">
        <input type="hidden" name="primary_ref" value="{{$result['primary_ref']}}">
        <input type="hidden" name="fp_timestamp" value="{{$result['timestamp']}}">
        <input type="hidden" name="fingerprint" value="{{$result['fingerprint']}}">
        <input type="hidden" name="display_receipt" value="{{$result['display_receipt']}}">
        <input type="hidden" name="return_url" value="{{$result['return_url']}}">
        <input type="hidden" name="return_url_text" value="{{$result['return_url_text']}}">
        <input type="hidden" name="return_url_target" value="{{$result['return_url_target']}}">
        <input type="hidden" name="cancel_url" value="{{$result['cancel_url']}}">
        <input type="hidden" name="confirmation" value="{{$result['confirmation']}}">
        <input type="hidden" name="template" value="{{$result['template']}}">
        <input type="hidden" name="primary_ref_name" value="{{$result['primary_ref_name']}}">
        <input type="hidden" name="card_types" value="{{$result['card_types']}}">
        <input type="hidden" name="page_style_url" value="{{$result['external_css']}}">
    </form>


    <iframe name="secureframe" width="100%" height="300" frameBorder="0"></iframe>
</div>

