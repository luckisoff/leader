<form id="myCCForm" action="https://www.mysite.com/examplescript.php" method="post">
    <input name="token" type="hidden" value="" />
    <div>
      <label>
        <span>Card Number</span>
        <input id="ccNo" type="text" value="" autocomplete="off" required />
      </label>
    </div>
    <div>
      <label>
        <span>Expiration Date (MM/YYYY)</span>
        <input id="expMonth" type="text" size="2" required />
      </label>
      <span> / </span>
      <input id="expYear" type="text" size="4" required />
    </div>
    <div>
      <label>
        <span>CVC</span>
        <input id="cvv" type="text" value="" autocomplete="off" required />
      </label>
    </div>
    <input type="submit" value="Submit Payment" />
  </form>