
import './bootstrap';
import { createApp } from 'vue';


const app = createApp({});

import LoanCalculatorForm from './components/LoanCalculatorForm.vue';
import AmortizationSchedule from './components/AmortizationSchedule.vue';
import AmortizationScheduleWithRepayment from './components/AmortizationScheduleWithRepayment.vue';

app.component('loan-calculator-form', LoanCalculatorForm);
app.component('amortization-schedule', AmortizationSchedule);
app.component('amortization-schedule-with-repayment', AmortizationScheduleWithRepayment);

app.mount('#app');
