$(function(){

	var addCartPlus = function(event){

		var $qtyBox = $("#catalogElement .qtyBlock  .qty");
		var $addCartBtn = $("#catalogElement .addCart.changeQty");

		var xCurrentQtyValue = Number($qtyBox.val());
		var xQtyStep = Number($qtyBox.data("step"));
		var xQtyExpression = Number((xCurrentQtyValue * 10 + xQtyStep * 10) / 10); //js magic .9999999

		var _enableTrace = $qtyBox.data("enable-trace");
		var _maxQuantity = Number($qtyBox.data("max-quantity"));

		var __qtyError = false;
		var xTmpExpression = 0;

		if(_enableTrace == "Y"){

			xTmpExpression = xQtyExpression;
			xQtyExpression = (xQtyExpression > _maxQuantity) ? _maxQuantity : xQtyExpression;

			if(xTmpExpression != xQtyExpression){
				__qtyError = true;
			}

		}

		$qtyBox.val(xQtyExpression);
		$addCartBtn.data("quantity", xQtyExpression);

		//set or remove error
		__qtyError === true ? $qtyBox.addClass("error") : $qtyBox.removeClass("error");

		return event.preventDefault();

	};

	var addCartMinus = function(event){

		var $qtyBox = $("#catalogElement .qtyBlock  .qty");
		var $addCartBtn = $("#catalogElement .addCart.changeQty");

		var xCurrentQtyValue = Number($qtyBox.val());
		var xQtyStep = Number($qtyBox.data("step"));
		var xQtyExpression = Number((xCurrentQtyValue * 10 - xQtyStep * 10) / 10); //js magic .9999999

		var _enableTrace = $qtyBox.data("enable-trace");
		var _maxQuantity = Number($qtyBox.data("max-quantity"));

		var __qtyError = false;
		var xTmpExpression = 0;

		xQtyExpression = xQtyExpression > xQtyStep ? xQtyExpression : xQtyStep;

		if(_enableTrace == "Y"){

			xTmpExpression = xQtyExpression;
			xQtyExpression = (xQtyExpression > _maxQuantity) ? _maxQuantity : xQtyExpression;

			if(xTmpExpression != xQtyExpression){
				__qtyError = true;
			}

		}

		$qtyBox.val(xQtyExpression);
		$addCartBtn.data("quantity", xQtyExpression);

		//set or remove error
		__qtyError === true ? $qtyBox.addClass("error") : $qtyBox.removeClass("error");

		return event.preventDefault();

	};

	var addCartChange = function(event){

		var $this = $(this);
		var $addCartBtn = $("#catalogElement .addCart.changeQty");

		var xCurrentQtyValue = $this.val();
		var xQtyStep = Number($this.data("step"));

		var _enableTrace = $this.data("enable-trace");
		var _maxQuantity = Number($this.data("max-quantity"));

		var __qtyError = false;
		var xTmpExpression = 0;

		if(xCurrentQtyValue.replace(/[^\d.]/gi, '') != xCurrentQtyValue){
			xCurrentQtyValue = xQtyStep;
		}else{
			xCurrentQtyValue = Number(xCurrentQtyValue);
		}

		xQtyExpression = Math.ceil(xCurrentQtyValue / xQtyStep) * xQtyStep;

		if(_enableTrace == "Y"){

			xTmpExpression = xQtyExpression;
			xQtyExpression = (xQtyExpression > _maxQuantity) ? _maxQuantity : xQtyExpression;

			if(xTmpExpression != xQtyExpression){
				__qtyError = true;
			}

		}

		$this.val(xQtyExpression);
		$addCartBtn.data("quantity", xQtyExpression);

		//set or remove error
		__qtyError === true ? $this.addClass("error") : $this.removeClass("error");

	};

	$(document).on("click", "#catalogElement .qtyBlock .plus", addCartPlus);
	$(document).on("click", "#catalogElement .qtyBlock .minus", addCartMinus);
	$(document).on("change", "#catalogElement .qtyBlock .qty", addCartChange);

});