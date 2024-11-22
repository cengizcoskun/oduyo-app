<template>
    <div class="payment-container">
        <h1 class="title">Payment Page</h1>

        <!-- Loading Animation -->
        <div v-if="isProcessing" class="loading-overlay">
            <div class="spinner"></div>
            <p>Processing your payment, please wait...</p>
        </div>

        <form @submit.prevent="submitPayment" class="payment-form" id="payment-form">
            <input type="hidden" name="_token" :value="csrf">
            <div class="form-group">
                <label for="cardholder_name">Cardholder Name: (Yasin Cengiz Coskun)</label>
                <input type="text" id="cardholder_name" v-model="cardholder_name" placeholder="Yasin Cengiz Coşkun" />
            </div>
            <div class="form-group">
                <label for="cc_no">Credit Card Number: (5549605007824017)</label>
                <input type="text" id="cc_no" v-model="cc_no" placeholder="1234 5678 9012 3456" />
            </div>
            <div class="form-group-row">
                <div class="form-group">
                    <label for="cc_month">Expiration Date (MM/YY): (12/25)</label>
                    <div class="expiry-fields">
                        <input type="text" id="cc_month" v-model="cc_month" placeholder="MM" maxlength="2" />
                        <input type="text" id="cc_year" v-model="cc_year" placeholder="YY" maxlength="2" />
                    </div>
                </div>
            </div>
            <div class="form-group-row">
                <div class="form-group">
                    <label for="cc_cvc">CVC: (460)</label>
                    <input type="text" id="cc_cvc" v-model="cc_cvc" placeholder="123" maxlength="3" />
                </div>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" id="threeD_secure" v-model="threeD_secure" />
                    Use 3D Secure
                </label>
            </div>
            <div class="form-group">
                <label for="totalAmount">Total Amount:</label>
                <input type="text" id="totalAmount" v-model="totalAmount" />
            </div>
            <button type="submit" class="submit-button" :disabled="isProcessing">
                Make Payment
            </button>
        </form>
        <p v-if="message" class="message">{{ message }}</p>
    </div>
</template>

<style scoped>
/* General Page Style */
.payment-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

.title {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Form Styles */
.payment-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group-row {
    display: flex;
    gap: 10px;
}

.label {
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

input[type="checkbox"] {
    margin-right: 10px;
}

input:focus {
    outline: none;
    border-color: #4caf50;
}

.expiry-fields {
    display: flex;
    gap: 10px;
}

.submit-button {
    background-color: #4caf50;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-button:disabled {
    background-color: #aaa;
    cursor: not-allowed;
}

.submit-button:hover:not(:disabled) {
    background-color: #45a049;
}

/* Message Style */
.message {
    margin-top: 20px;
    color: #d32f2f;
    font-weight: bold;
    text-align: center;
}

/* Loading Spinner */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 1000;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #ccc;
    border-top-color: #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.loading-overlay p {
    margin-top: 10px;
    font-size: 16px;
    color: #555;
}
</style>


<script>
export default {
    data() {
        return {
            isProcessing: false,
            message: '',
            cardholder_name: '',
            cc_no: '',
            cc_month: '',
            cc_year: '',
            cc_cvc: '',
            threeD_secure: '',
            totalAmount: 0
        };
    },
    computed: {
        csrf() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        },
        isValidName() {
            return this.cardholder_name.length >= 3;
        },
        isValidCardNumber() {
            return /^\d{16}$/.test(this.cc_no);
        },
        isValidExpiry() {
            return /^(0[1-9]|1[0-2])$/.test(this.cc_month) && /^\d{2}$/.test(this.cc_year);
        },
        isValidCVC() {
            return /^\d{3}$/.test(this.cc_cvc);
        },
        isFormValid() {
            return this.isValidName && this.isValidCardNumber && this.isValidExpiry && this.isValidCVC;
        },
    },
    methods: {
        async submitPayment() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            this.isProcessing = true;
            this.message = '';

            if (!this.isFormValid) {
                this.message = 'Please fill in all fields correctly.';
            } else {
                try {
                    if (this.threeD_secure) {
                        const formData = {
                            'cardholder_name': this.cardholder_name,
                            'cc_no': this.cc_no,
                            'cc_month': this.cc_month,
                            'cc_year': this.cc_year,
                            'cc_cvc': this.cc_cvc,
                            'threeD_secure': this.threeD_secure,
                            'totalAmount': this.totalAmount,
                            '_token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        };

                        const form = document.createElement("form");
                        form.setAttribute("method", "POST");
                        form.setAttribute("action", '/payment');

                        for (const key in formData) {
                            if (Object.hasOwnProperty.call(formData, key)) {
                                const input = document.createElement("input");
                                input.setAttribute("type", "hidden");
                                input.setAttribute("name", key);
                                input.setAttribute("value", formData[key]);
                                form.appendChild(input);
                            }
                        }

                        document.body.appendChild(form);
                        form.submit();

                        return;
                    } else {

                        const response = await axios.post('/payment', {
                            cardholder_name: this.cardholder_name,
                            cc_no: this.cc_no,
                            cc_month: this.cc_month,
                            cc_year: this.cc_year,
                            cc_cvc: this.cc_cvc,
                            threeD_secure: this.threeD_secure,
                            totalAmount: this.totalAmount
                        });

                        console.log(response.data);

                        if (response.data.success) {
                            this.message = 'Ödeme başarılı!';
                        } else {
                            // this.message = 'Ödeme başarısız.';
                            this.message = 'Error Code: ' + response.data.errorCode + ' - Error Message: ' + response.data.message;
                        }
                    }
                } catch (err) {
                    this.message = 'Error!: ' + err.message;
                }
            }

            this.isProcessing = false;
        },
    },
};
</script>
