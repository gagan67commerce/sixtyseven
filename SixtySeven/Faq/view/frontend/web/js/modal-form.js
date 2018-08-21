define(
        [
            'jquery',
            'Magento_Ui/js/modal/modal'
        ],
        function(
            $,
            modal
        ) {  
            'use strict';
            $.widget('sixtyseven.faq', {
                options: {
                    submitUrl: '',
                },                                        
                _create: function() {
                    this._initElement();
                },
                _initElement: function() {
                    var that = this;
                    var options = {
                        type: 'popup',
                        responsive: true,
                        innerScroll: true,
                        title: 'Ask A Question',
                        buttons: [{
                            text: $.mage.__('Submit Question'),
                            class: '',
                            click: function () {
                                var form_data = $("#popup-modal").serialize();                                            
                                $.ajax({
                                    url: that.options.formUrl,
                                    type: 'POST',
                                    data : form_data,
                                    success: function(data){                                
                                        console.log(data);
                                    },
                                    error: function(result){
                                        console.log('no response !');
                                    }
                                });
                                this.closeModal();
                            }
                        }],
                        /**
                         * Escape key press handler,
                         * close modal window
                         */
                        escapeKey: function () {
                            if (this.options.isOpen && this.modal.find(document.activeElement).length ||
                                this.options.isOpen && this.modal[0] === document.activeElement) {
                                this.closeModal();
                            }
                        }
                    };
                    var popup = modal(options, $('#popup-modal'));
                    $(".open-modal-form").on('click',function(){ 
                        $("#popup-modal").modal("openModal");
                    });
                },
            });
            return $.sixtyseven.faq;
        }
);
