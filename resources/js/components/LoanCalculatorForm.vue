<template>
  <div class="container-fluid">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Mortgage Loan Calculator</div>
                    <div v-if="errors.length > 0" class="text-danger">
                      <ul>
                        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                      </ul>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="generateAmortization">
                          <div class="mb-3">
                            <label for="loan_amount" class="form-label">Loan Amount</label>
                            <input type="text" name = "loan_amount" class="form-control" v-model="formData.loan_amount" required>
                          </div>
                          <div class="mb-3">
                            <label for="annual_interest_rate" class="form-label">Annual Interest Rate</label>
                            <input type="text" name = "annual_interest_rate" class="form-control" v-model="formData.annual_interest_rate" required>
                          </div>
                          <div class="mb-3">
                            <label for="loan_term" class="form-label">Loan Term(Years)</label>
                            <input type="text" name = "loan_term" class="form-control" v-model="formData.loan_term" required>
                          </div>
                          <div class="mb-3">
                            <label for="extra_repayment" class="form-label">Repayment amount(If applicable)</label>
                            <input type="text" name = "extra_repayment" class="form-control" v-model="formData.extra_repayment">
                          </div>
                          

                          <button type="submit" class="btn btn-success">Generate</button>
                        </form>
                        

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <amortization-schedule v-if="amortizationSchedule.length > 0" :amortization-schedule="amortizationSchedule"></amortization-schedule>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          
            <amortization-schedule-with-repayment v-if="amortizationScheduleWithRepayment.length > 0" :amortization-schedule-with-repayment="amortizationScheduleWithRepayment"></amortization-schedule-with-repayment>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
          return {
            formData:{
              loan_amount: '',
              annual_interest_rate: '',
              loan_term: '',
              extra_repayment: '',
            },
            errors : [],
            amortizationSchedule: [],
            amortizationScheduleWithRepayment: [],
            responseData : {},
          }
        },
        methods: {
          generateAmortization() {
            let vm = this;
            vm.amortizationSchedule = [];
            vm.amortizationScheduleWithRepayment = [];
            axios.post('api/calculate-loan',vm.formData)
              .then(response => {
                // Handle the successful response here
                vm.responseData = response.data;
                vm.amortizationSchedule = vm.responseData.amortization_schedule.data;
                vm.amortizationScheduleWithRepayment = vm.responseData.amortization_schedule_with_repayment.data;
                vm.errors = [];

              })
              .catch(error => {
                if (!!error.response && error.response.status === 422) {
                  this.errors = Object.values(error.response.data.errors).flat();
                }
                
              });
          },
        }

    }
</script>
