/**
 * Before all, this file should be splitted in order to make a file
 * for each responsability (tracking, Namespace, Validation, Form...).
 * This is improvable, yes, but this is a first step.
 */


/**
 * This is the main package to set all variables.
 *
 * This way allow us set variables in package context instead of global.
 */
Namespace = {};


/**
 * This class implements Module pattern in order to set a unique
 * instance in Namespace. Contains methods to validate inputs.
 *
 * Example of usage:
 *
 * <code>
 *     Namespace.ValidatorConstraints.validateMandatory( "string" );
 *     Namespace.ValidatorConstraints.validateEmail( "account@domain.com" );
 * </code>
 */
(function (NS) {

    var notBlankConstraint = null;
    var emailConstraint = null;

    notBlankConstraint = function (input) {
        return ( typeof input !== "undefined" && input.trim() !== "" );
    };

    emailConstraint = function (input) {
        var emailPattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        return ( notBlankConstraint(input) && emailPattern.test(input) );
    };

    NS.ValidatorConstraints = {
        "validateMandatory" : notBlankConstraint,
        "validateEmail"     : emailConstraint
    };

})(Namespace);


/**
 * Tracking system module.
 *
 * This module allow you tracking just events (for now) by means of a simple method.
 *
 * Example of usage:
 * <code>
 *     Namespace.TrackingSystem.trackEvent({section: "contact", action: "send"});
 * </code>
 */
(function (NS, window, undefined) {

    var _validateEvent = function (event) {
        return ( "undefined" !== typeof event.section && "undefined" !== typeof event.action );
    };

    /**
     * Main class of this module.
     */
    function TrackingSystem ()
    {
    };

    /**
     * This method is one used to track events.
     *
     * @throws Exception if event is not valid.
     * @param {Object} event This is event to track, must contains section and action.
     */
    TrackingSystem.prototype.trackEvent = function(event)
    {
        if ( !_validateEvent(event) ) {
            throw "Event to track isn't valid";
            return false;
        }

        window._gaq.push([
            '_trackEvent',
            event.section,
            event.action,
            ("undefined" !== typeof event.data) ? event.data : undefined
        ]);
    }

    Namespace.TrackingSystem = new TrackingSystem();
    
})(Namespace, window);


/**
 * The FormInstance class is a model of commons forms.
 *
 * With this class we are able to manage the request/response, validations
 * and what we have to do on error/success events.
 *
 * Example of usage:
 *
 * <code>
        formInstance = new FormInstance($('#form-id')[0]);
        formInstance.init();
 * </code>
 *
 * If we want to add some funcionalities like setters, or other, we should
 * implement fluid api to allow method chaining calls.
 *
 * @param {DOMObject} form The instance of form we can manage.
 */
FormInstance = function (form)
{
    /**
     * This property contains an instance of Validator stored in Namesapce.
     */
    this.validator = Namespace.ValidatorConstraints;


    /**
     * This property contains the form instance.
     */
    this.form = form;


    /**
     * This property contains the form instance.
     */
    this.submitButton = {

        cssSelector: "input[type=submit]",

        enable: function () {

            $(this.form).find(this.submitButton.cssSelector)
                .removeAttr("disabled")
                .removeClass("form-sending")
                .val("Enviar");
        },

        disable: function () {

            $(this.form).find(this.submitButton.cssSelector)
                .attr("disabled", "disabled")
                .addClass("form-sending")
                .val("Enviando...");
        }
    };


    /**
     * Action to execute when server is OK.
     *
     * @param {Object} data Response receive from server.
     */
    this._onSuccess = function (data) {

        this._showSuccessMessage(data.message);
        this._clearForm();

        Namespace.TrackingSystem.trackEvent({
            section : "contact", 
            action  : "send",
            data    : "OK"
        });
    }


    /**
     * Action to execute when an error is produced.
     *
     * @param {Object} xhr Ajax response receive from server.
     */
    this._onError = function (xhr, some) {

        var response = $.parseJSON(xhr.responseText);

        Namespace.TrackingSystem.trackEvent({
            section : "contact", 
            action  : "send",
            data    : "Error - Server sent: " + xhr.status
        });

        switch (xhr.status) {

            case 400: {

                for( field in response ) {
                    this._renderErrors(field, response[field]);
                }

                break;
            }

            default: {
                /** @todo improve show errors */
                alert(response.error.message);
            }

        }

        return true;
    };


    /**
     * Action to execute always: error, success or form isn't valid.
     *
     * @param {Object} xhr Ajax response receive from server.
     * @param {String} textStatus The status as text sent by server.
     */
    this._onComplete = function (xhr, textStatus) {

        this.submitButton.enable.call(this);

        if ( "undefined" === typeof xhr )
        {
            Namespace.TrackingSystem.trackEvent({
                section : "contact", 
                action  : "send",
                data    : "Error - Validation client side."
            });
        }

        return true;
    };


    /**
     * Show message when server returned 200.
     *
     * @param {String} message This is success message returned by server.
     */
    this._showSuccessMessage = function (message) {

        var id = "form-message-success";
        var htmlContainer = null;
        var self = this;

        if ( 1 > $("#" + id).length ) {

            htmlContainer = document.createElement("span");
            htmlContainer.id = "form-message-success";

            $(htmlContainer).html(message).hide();
            $(this.form).parent().append(htmlContainer, this.form);
        }
        $(htmlContainer).html(message).slideDown("slow").delay(5000).slideUp("fast");
    }


    /**
     * This method is executed when we want render and error in a input.
     *
     * @param {String} field Id of field we want render error.
     * @param {String} message Message to show.
     */
    this._renderErrors = function (field, message) {

        // Oh! static class called here!?
        $(this.form).find("#" + field)
            .parent()
            .find("label")
            .addClass("form-error")
            .find(".form-label-message")
            .html( "(" + message + ")" );
    };


    /**
     * This method come to extract the events must be attached to the form on submit.
     *
     * @see FormInstance.prototype.init
     */
    this._attachEventToSubmitForm = function () {

        var self = this;
        $(this.form).submit(function (e) {

            e.preventDefault();

            self.submitButton.disable.call(self);
            self.resetForm(e.target);

            Namespace.TrackingSystem.trackEvent({
                section : "contact", 
                action  : "send"
            });

            if (self.validateForm(e.target))
            {
                self.sendForm(e.target); 
            }
            else
            {
                self._onComplete();
            }

        });
    }
};


/**
 * Delete all errors of form.
 *
 * Delete error class from labels and the validation message.
 */
FormInstance.prototype.resetForm = function ()
{
    $(this.form).find("label").each(function (index, htmlTag){
        $(htmlTag).removeClass("form-error")
            .find(".form-label-message")
            .html("");
    });
};


/**
 * Clear all values of form.
 */
FormInstance.prototype._clearForm = function ()
{
    $(this.form).find("input").each(function (index, htmlTag){
        $(this).val("");
    });

    $(this.form).find("textarea").each(function (index, htmlTag){
        $(this).val("");
    });
};


/**
 * Yes, I know, isn't my responsability but.. Do we have time to create
 * unique responsability class? :-)
 */
FormInstance.prototype.validateForm = function () {

    var self = this;
    var formIsValid = true;
    var inputIsValid = false;

    $(this.form).find(".form-validate").each(function (index, input){
        if ( $(input).hasClass("validate-mandatory") ) {
            inputIsValid = self.validator.validateMandatory($(input).val());
            formIsValid &= inputIsValid;
            if (!inputIsValid) {
                /** @todo set this message from server */
                self._renderErrors(input.id, "Este valor no debería estar vacío");
            }
        } else if ( $(input).hasClass("validate-email") ) {
            inputIsValid = self.validator.validateEmail($(input).val());
            formIsValid &= inputIsValid;
            if (!inputIsValid) {
                /** @todo set this message from server */
                self._renderErrors(input.id, "Este valor no es una dirección de email válida");
            }
        }
    });

    return ( formIsValid && $(this.form).find("textarea").val() );
};


/**
 * Send the form serialized to the server.
 *
 * @param {DOMObject} contactForm Form with data.
 */
FormInstance.prototype.sendForm = function (form) {

    var self = this;

    $.ajax({
        url         : $(form).attr('action'),
        data        : $(form).serialize(),
        dataType    : 'json',
        type        : 'POST',
        success     : function(data) {
            self._onSuccess.call(self, data);
        },
        error       : function (xhr) {
            self._onError.call(self, xhr);
        },
        complete    : function (xhr, textStatus) {
            self._onComplete.call(self, xhr);
        }
    });
}


/**
 * Init the form object.
 */
FormInstance.prototype.init = function () {
    this._attachEventToSubmitForm();
};


/**
 * This will be executed after render full page.
 */
$(document).ready(function () {

    /**
     * This way is a trick, we would should make a module for each 
     * page instead of check for each page if any thing is available.
     *
     * But, this is only the first version, step-by-step!!
     */
    var contactForm = $('#contact');
    var formInstance = null;

    if (0 !== contactForm.length)
    {
        formInstance = new FormInstance(contactForm[0]);
        formInstance.init();
    }

});