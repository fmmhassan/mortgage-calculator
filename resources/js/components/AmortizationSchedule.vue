<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Amortization Schedule</h3>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Month number</th>
                      <th>Starting balance</th>
                      <th>Monthly payment</th>
                      <th>Principal component</th>
                      <th>Interest component</th>
                      <th>Ending balance</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="scheduleRow in amortizationSchedule" :key="'amortization'+scheduleRow.id">
                      <td>{{ scheduleRow.month_number }}</td>
                      <td>{{ scheduleRow.starting_balance }}</td>
                      <td>{{ scheduleRow.monthly_payment }}</td>
                      <td>{{ scheduleRow.principal_component }}</td>
                      <td>{{ scheduleRow.interest_component }}</td>
                      <td>{{ scheduleRow.ending_balance }}</td>
                      
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['amortizationSchedule']
    }
</script>
