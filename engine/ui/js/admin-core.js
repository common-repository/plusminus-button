jQuery(document).ready(function() {
    // jQuery('.iv-fontpicker').fontselect();
    // ivpmb_applySpinnerOnAdminPage();
});

function ivpmb_applySpinnerOnAdminPage() {
    let spinner = jQuery('#iv-spinner-form-container :input[type="number"]');
    if (spinner && !jQuery.isEmptyObject(spinner)) {
        spinner = spinner.spinner();
        ivpmb_applyButtonCaptions(spinner, '.ui-spinner-down', '-');
        ivpmb_applyButtonCaptions(spinner, '.ui-spinner-up', '+');
    }
}

function ivpmb_applyButtonCaptions(spinner, direction, caption) {
    let icon = jQuery(direction + " .ui-button-text .ui-icon");
    for (let i = 0; i < icon.length; i++) {
        icon[i].textContent = caption;
    }
}

function ivpmb_applyColor(fieldId, labelId) {
    let field = jQuery('#' + fieldId);
    let label = jQuery('#' + labelId);
    let value = field[0].value;
    if (ivpmb_isColor(value)) {
        label[0].value = value;
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            if (label[0].className.includes('iv-wizard-colorpicker')) {
                label.spectrum("set", value);
            }
        }
    }
}

function ivpmb_isColor(value) {
    return /^#[0-9A-F]{6}$/i.test(value);
}
