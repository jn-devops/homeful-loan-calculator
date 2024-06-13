<script setup>
import {ref} from 'vue';

const props = defineProps({
    loan: Object,
    peso: Object
});

console.log('loan_data: ', props.loan );
</script>
<template>
    <div class="text-2xl grid grid-cols-3 gap-4">
        <div class="col-span-1">
            <div class="font-bold text-black">
                <h1>Borrower Details</h1>
            </div>
            <div class="bg-gray-50 rounded-lg grid grid-rows-1">
                <div>
                    <p>
                        <strong>{{ peso.format(loan_data?.borrower?.gross_monthly_income) }}</strong></p>
                    <p class="text-sm">Gross Monthly Income</p>
                </div>
            </div>
        </div>
        <div class="bg-green-100 col-span-2">
            2
        </div>
    </div>
</template>



<style lang="scss" scoped>

</style>