jQuery(document).ready(function() {
    ivpmb_activateSpinner();
    ivpmb_applyCartQuantityHandler();
});

jQuery(document).ajaxComplete(function(event, xhr, settings) {
    ivpmb_activateSpinner();
});

function ivpmb_activateSpinner() {
    if (ivbpmb_options.activeOnCart) {
        ivpmb_applySpinner('.woocommerce-cart');
    }
    if (ivbpmb_options.activeOnSingleProductPage) {
        ivpmb_applySpinner('.single-product');
        //quickview
        ivpmb_applySpinner('#wcqv_contend');
    }
    if (ivbpmb_options.activeOnShopPage) {
        ivpmb_applySpinner('li.product');
    }
}

function ivpmb_applySpinner(container) {
    let spinner = jQuery(container + ' :input[type="number"]');
    if (spinner && !jQuery.isEmptyObject(spinner)) {
        spinner = spinner.spinner({
            stop: ivpmb_onSpin
        });
        ivpmb_applyButtonCaptions(spinner, '.ui-spinner-down', '-');
        ivpmb_applyButtonCaptions(spinner, '.ui-spinner-up', '+');
        ivpmb_applyAdminStyles();
    }
    ivpmb_moveSpinnerBeforeAddButton();
}

function ivpmb_onSpin(event) {
    ivpmb_unlockUpdateCartButton();
    ivpmb_quantityChanged(event);
}

function ivpmb_applyButtonCaptions(spinner, direction, caption) {
    let icon = jQuery(direction + " .ui-button-text .ui-icon");
    for (let i = 0; i < icon.length; i++) {
        icon[i].textContent = caption;
    }
}

function ivpmb_unlockUpdateCartButton() {
    let button = jQuery(':button[name="update_cart"]');
    if (button && !jQuery.isEmptyObject(button)) {
        button.removeAttr('disabled');
    }
}

function ivpmb_applyCartQuantityHandler() {
    let products = jQuery(".woocommerce .products");
    products.on("click", ".quantity input", function () {
        return false;
    });
    products.on("change input", ".quantity .qty", ivpmb_quantityChanged);
    products.on("keypress", ".quantity .qty", ivpmb_enterPressed);
}

function ivpmb_quantityChanged(event) {
    let addToCartButton = jQuery(event.target).parents(".product").find(".add_to_cart_button");
    let quantity = event.target.value;
    // For AJAX add-to-cart actions
    addToCartButton.data("quantity", quantity);
    // For non-AJAX add-to-cart actions
    let productId = addToCartButton.attr("data-product_id");
    addToCartButton.attr("href", "?add-to-cart=" + productId + "&quantity=" + quantity);
}

function ivpmb_enterPressed(e) {
    if ((e.which || e.keyCode) === 13) {
        jQuery(e.target).parents(".product").find(".add_to_cart_button").trigger("click");
    }
}

function ivpmb_moveSpinnerBeforeAddButton() {
    let products = jQuery('li.product');
    if (products) {
        products.each(function (i, product) {
            let spinner = jQuery(product).find('.quantity');
            let button = jQuery(product).find('.button.product_type_simple.add_to_cart_button.ajax_add_to_cart');
            button.before(spinner);
            if (button.is(':visible')) {
                spinner.css('display', 'inline-block');
            } else {
                spinner.css('display', 'none');
            }
        });
    }
}

function ivpmb_applyAdminStyles() {
    let spinner = jQuery('.ui-spinner');
    ivpmb_applyPadding(spinner);
    ivpmb_applyFont(spinner);
    ivpmb_applyFontsize(spinner);
    ivpmb_applyColor(spinner);
    ivpmb_applyBackground(spinner);
}

function ivpmb_applyPadding(spinner) {
    if (!ivbpmb_options.marginTop && !ivbpmb_options.marginLeft &&
        !ivbpmb_options.marginBottom && !ivbpmb_options.marginRight) {
        return;
    }
    let marginTop = !ivbpmb_options.marginTop ? 0 : ivbpmb_options.marginTop;
    let marginLeft = !ivbpmb_options.marginLeft ? 0 : ivbpmb_options.marginLeft;
    let marginBottom = !ivbpmb_options.marginBottom ? 0 : ivbpmb_options.marginBottom;
    let marginRight = !ivbpmb_options.marginRight ? 0 : ivbpmb_options.marginRight;
    let margin = marginTop + 'px ' + marginRight + 'px ' + marginBottom + 'px ' + marginLeft + 'px';
    spinner.css('margin', margin);
}

function ivpmb_applyFont(spinner) {
    let font = ivbpmb_options.font;
    if (!font || font === "'-'") {
        return;
    }
    spinner.find('input').css('font-family', ivbpmb_options.font);
}

function ivpmb_applyFontsize(spinner) {
    if (!ivbpmb_options.fontsize) {
        return;
    }
    let fontsize = ivbpmb_options.fontsize + 'px';
    spinner.find('input').css('font-size', fontsize);
}

function ivpmb_applyColor(spinner) {
    if (!ivbpmb_options.color) {
        return;
    }
    spinner.find('input').css('color', ivbpmb_options.color);
}

function ivpmb_applyBackground(spinner) {
    if (!ivbpmb_options.background) {
        return;
    }
    spinner.css('background', ivbpmb_options.background);
}