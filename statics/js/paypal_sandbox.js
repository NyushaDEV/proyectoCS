// Render the PayPal button
paypal.Button.render({
// Set your environment
    env: 'sandbox', // sandbox | production

// Specify the style of the button
    style: {
        layout: 'vertical',  // horizontal | vertical
        size:   'medium',    // medium | large | responsive
        shape:  'rect',      // pill | rect
        color:  'gold'       // gold | blue | silver | white | black
    },

// Specify allowed and disallowed funding sources
//
// Options:
// - paypal.FUNDING.CARD
// - paypal.FUNDING.CREDIT
// - paypal.FUNDING.ELV
    funding: {
        allowed: [
            paypal.FUNDING.CARD,
            paypal.FUNDING.CREDIT
        ],
        disallowed: []
    },

// PayPal Client IDs - replace with your own
// Create a PayPal app: https://developer.paypal.com/developer/applications/create
    client: {
        sandbox: 'AQxM1L1wqpY_4A7Q4a7eBzB-RmWaC1giKoug6GIUhVQiTrK2OrZE2afR6Ae0uJeV1ZjURicz69hwQ4xg'
        //production: '<insert production client id>'
    },

    payment: function (data, actions) {
        return actions.payment.create({
            payment: {
                transactions: [
                    {
                        amount: {
                            total: '0.01',
                            currency: 'USD'
                        }
                    }
                ]
            }
        });
    },

    onAuthorize: function (data, actions) {
        return actions.payment.execute()
            .then(function () {
                window.alert('Payment Complete!');
            });
    }
}, '#paypal-button-container');