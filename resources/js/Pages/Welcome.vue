<script setup xmlns="http://www.w3.org/1999/html">
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import TableComponent from '@/MyComponents/TableComponent.vue';
import MyCard from '@/MyComponents/MyCard.vue';
import RLIModal from '@/MyComponents/RLIModal.vue';
import LoanCalculatorDetails from '@/MyComponents/LoanCalculatorDetails.vue';
import ReceiveCashLogo from '@/MyComponents/ReceiveCashLogo.vue';
import CalendarLogo from '@/MyComponents/CalendarLogo.vue';
import PercentageLogo from '@/MyComponents/PercentageLogo.vue';
import RevenueLogo from '@/MyComponents/RevenueLogo.vue';
import DocumentLogo from '@/MyComponents/DocumentLogo.vue';
import MortgageLogo from '@/MyComponents/MortgageLogo.vue';
import RequestmoneyLogo from '@/MyComponents/RequestmoneyLogo.vue';
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    loan: Object
});

const form = useForm({
    age: 45,
    regional: true,
    gross_monthly_income: 15000,
    total_contract_price: 850000,
    appraised_value: 850000,
    loan_amount: '',
    equity: ''
});

const loan_data = ref({});
const counter = ref(0);

watch (
    () => usePage().props.flash.event,
    (event) => {
        switch (event?.name) {
            case 'loan.calculated':
                console.log('event1:', event?.data);
                loan_data.value = event?.data;
                counter.value = counter.value + 1;
                break;
        }
    },
    { immediate: true }
);

let showModal = ref(false);

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
const submit = () => {
    showModal.value = true;
    console.log('SM');
    form.post(route('loan-calculator'), {
        preserveScroll: true,
    });
};
const submitLG = () => {
    console.log('LG');
    form.post(route('loan-calculator'), {
        preserveScroll: true,
    });
};

let PHPeso = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'PHP',
});

function checkScreenSize() {
  const isSmallScreen = window.matchMedia('(max-width: 767px)').matches;
  showModal.value = isSmallScreen;
}

onMounted(() => {
  checkScreenSize();
  window.addEventListener('resize', checkScreenSize);
});

onBeforeUnmount(() => {
  window.removeEventListener('resize', checkScreenSize);
});

const regional = loan_data.value?.borrower?.regional;
const content = regional ? "Yes" : "No";
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white bg_layout"
        >
            <div class="relative w-full max-w-2xl px-4 lg:max-w-7xl">
                <header class="grid grid-rows-1 md:grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <svg
                            class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]"
                            viewBox="0 0 62 65"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z"
                                fill="currentColor"
                            />
                        </svg>
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <MyCard>
                        
                        <template #contentLeft>
                            <!-- <LoanCalculator 
                            :form="form" 
                            :peso="PHPeso" 
                            :loan_data="loan_data"
                            :counter="counter"
                            /> -->
                            <div id="screenshot-container" class="relative w-full">
                                <form>
                                    <div class="mt-4">
                                        <InputLabel for="gross_monthly_income" value="Gross Monthly Income" />

                                        <TextInput
                                            id="gross_monthly_income"
                                            type="number"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-50"
                                            v-model="form.gross_monthly_income"
                                            step="1000"
                                        />
                                        <div class="text-xs text-gray-600 dark:text-gray-400">*from pay slip</div>
                                        <InputError class="mt-2" :message="form.errors.gross_monthly_income" />
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="age" value="Age" />

                                        <TextInput
                                            id="age"
                                            type="number"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-50"
                                            v-model="form.age"
                                            min="0"
                                        />
                                        <div class="text-xs text-gray-600 dark:text-gray-400">*from eKYC</div>
                                        <InputError class="mt-2" :message="form.errors.age" />
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="regional" value="Regional" />

                                        <Checkbox
                                            id="regional"
                                            v-model:checked="form.regional"
                                        />
                                        <div class="text-xs text-gray-600 dark:text-gray-400">*from Jotform</div>
                                        <InputError class="mt-2" :message="form.errors.regional" />
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="total_contract_price" value="Total Contract Price" />

                                        <TextInput
                                            id="total_contract_price"
                                            type="number"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-50"
                                            v-model="form.total_contract_price"
                                            step="10000"
                                        />
                                        <div class="text-xs text-gray-600 dark:text-gray-400">*from SKU</div>
                                        <InputError class="mt-2" :message="form.errors.total_contract_price" />
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="appraised_value" value="Appraised Value" />

                                        <TextInput
                                            id="appraised_value"
                                            type="number"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-50"
                                            v-model="form.appraised_value"
                                            step="10000"
                                        />
                                        <div class="text-xs text-gray-600 dark:text-gray-400">*from Bank or Pag-IBIG</div>
                                        <InputError class="mt-2" :message="form.errors.appraised_value" />
                                    </div>

                                    <template>
                                        <div class="mt-4">
                                            <InputLabel for="loan_amount" value="Loan Amount" />

                                            <TextInput
                                                id="loan_amount"
                                                type="number"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-50l"
                                                v-model="form.loan_amount"
                                                step="10000"
                                            />

                                            <InputError class="mt-2" :message="form.errors.loan_amount" />
                                        </div>

                                        <div class="mt-4">
                                            <InputLabel for="equity" value="Equity" />

                                            <TextInput
                                                id="equity"
                                                type="number"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-50"
                                                v-model="form.equity"
                                                step="10000"
                                            />

                                            <InputError class="mt-2" :message="form.errors.equity" />
                                        </div>
                                    </template>

                                    <div class="hidden md:flex items-center justify-end mt-4">
                                        <PrimaryButton 
                                        @click.prevent="submitLG"
                                        class="w-4/5 mx-auto rounded-full flex justify-center default_bg-color" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Calculate
                                        </PrimaryButton>
                                    </div>
                                    <div class="md:hidden mt-4">
                                        <PrimaryButton 
                                        @click.prevent="submit"
                                        class="w-full mx-auto rounded-full flex justify-center default_bg-color" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Calculate
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </template>
                        <template #contentRight>
                            <div class="text-2xl grid grid-cols-3 gap-4 default_text">
                                <div class="col-span-1">
                                    <div class="font-bold default_text">
                                        <h1 class="default_title-text">Borrower Details</h1>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg grid grid-rows-1 mt-4 p-4 border hover:border-rose-500">
                                        <div class="">
                                            <p class="text-xl">
                                                <strong>{{ PHPeso.format(loan_data?.borrower?.gross_monthly_income) }}</strong></p>
                                            <p class="text-sm text-gray-400">Gross Monthly Income</p>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-xl">
                                                <strong>{{ loan_data?.borrower?.birthdate }}</strong>
                                            </p>
                                            <p class="text-sm text-gray-400">Birthdate</p>
                                        </div>
                                        <div class="mt-4">
                                            <p class="capitalize text-xl">
                                                <strong>{{ loan_data?.borrower?.regional === true ? 'Yes' : 'No' }}</strong>
                                            </p>
                                            <p class="text-sm text-gray-400">Outside NCR</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <div class="font-bold">
                                        <h1 class="default_title-text">Property Details</h1>
                                    </div>
                                    <div class="bg-gray-50 grid grid-cols-2 rounded-lg mt-4 border hover:border-rose-500">
                                        <div class="p-4">
                                            <div class=" text-xl">
                                                <p class="capitalize">
                                                    <strong>{{ loan_data?.property?.market_segment }}</strong>
                                                </p>
                                                <p class="text-sm text-gray-400">Market Segment</p>
                                            </div>
                                            <div class="mt-4">
                                                <p class=" text-xl">
                                                    <strong>{{ PHPeso.format(loan_data?.property?.total_contract_price) }}</strong>
                                                </p>
                                                <p class="text-sm text-gray-400">Total Contract Price</p>
                                            </div>
                                            <div class="mt-4">
                                                <p class=" text-xl">
                                                    <strong>{{ PHPeso.format(loan_data?.property?.appraised_value) }}</strong>
                                                </p>
                                                <p class="text-sm text-gray-400">Appraisals Value</p>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <div class="">
                                                <p class=" text-xl">
                                                    <strong>{{ loan_data?.property?.loanable_value_multiplier * 100 }}%</strong>
                                                </p>
                                                <p class="text-sm text-gray-400">Loanable Multiplier</p>
                                            </div>
                                            <div class="mt-4">
                                                <p class="">
                                                    <strong>{{ PHPeso.format(loan_data?.property?.loanable_value) }}</strong>
                                                </p>
                                                <p class="text-sm text-gray-400">Loanable Value</p>
                                            </div>
                                            <div class="mt-4">
                                                <p class=" text-xl">
                                                    <strong>{{ loan_data?.property?.disposable_income_requirement_multiplier * 100 }}%</strong>
                                                </p>
                                                <p class="text-sm text-gray-400">Disposable Income Req. Multiplier</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 default_text">
                                <div class="font-bold">
                                    <h1 class="text-2xl default_title-text">Loan Details</h1>
                                </div>
                                <div class="mt-2">
                                    <div class="grid grid-cols-3 dark:text-white light:text-black gap-3 font-bold">
                                        <div class="flex gap-2 bg-gray-50 p-2 items-center rounded-lg border hover:border-rose-600">
                                            <!-- <LotAreaLogo /> -->
                                             <div class="bg-white shadow-sm rounded-full p-2">
                                                 <ReceiveCashLogo class="w-10 h-10"/>
                                             </div>
                                            <div>
                                                <p class="text-2xl default_text-color">{{ PHPeso.format(loan_data?.loan_amount) }}</p>
                                                <p class="text-black text-sm">Loan Amount</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 bg-gray-50 p-2 items-center rounded-lg border hover:border-rose-600">
                                            <!-- <LotAreaLogo /> -->
                                             <div class="bg-white shadow-sm rounded-full p-2">
                                                 <CalendarLogo class="w-10 h-10"/>
                                             </div>
                                            <div>
                                                <p class="text-2xl default_text-color">{{ loan_data?.months_to_pay }}</p>
                                                <p class="text-black text-sm">Months to Pay</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 bg-gray-50 p-2 items-center rounded-lg border hover:border-rose-600">
                                            <!-- <LotAreaLogo /> -->
                                             <div class="bg-white shadow-sm rounded-full p-2">
                                                 <PercentageLogo class="w-10 h-10"/>
                                             </div>
                                            <div>
                                                <p class="text-2xl default_text-color">{{ loan_data?.annual_interest * 100 }}%</p>
                                                <p class="text-black text-sm">Annual Interest</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 dark:text-white light:text-black gap-3 mt-2 font-bold">
                                        <div class="flex gap-2 bg-gray-50 p-2 items-center rounded-lg border hover:border-rose-600">
                                            <!-- <LotAreaLogo /> -->
                                             <div class="bg-white shadow-sm rounded-full p-2">
                                                 <RevenueLogo class="w-10 h-10"/>
                                             </div>
                                            <div>
                                                <p class="text-2xl default_text-color">{{ PHPeso.format(loan_data?.joint_disposable_monthly_income) }}</p>
                                                <p class="text-black text-sm">Disposable Monthly Income (Joint)</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 bg-gray-50 p-2 items-center rounded-lg border hover:border-rose-600">
                                            <!-- <LotAreaLogo /> -->
                                             <div class="bg-white shadow-sm rounded-full p-2">
                                                 <DocumentLogo class="w-10 h-10"/>
                                             </div>
                                            <div>
                                                <p class="text-2xl default_text-color">{{ PHPeso.format(loan_data?.monthly_amortization) }}</p>
                                                <p class="text-black text-sm">Monthy Amortization</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 bg-gray-50 p-2 items-center rounded-lg border hover:border-rose-600">
                                            <!-- <LotAreaLogo /> -->
                                             <div class="bg-white shadow-sm rounded-full p-2">
                                                 <MortgageLogo class="w-10 h-10"/>
                                             </div>
                                            <div>
                                                <p class="text-2xl default_text-color">{{ PHPeso.format(loan_data?.equity) }}</p>
                                                <p class="text-black text-sm">Equity</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 dark:text-white light:text-black gap-3 mt-2 font-bold">
                                        <div class="flex gap-2 bg-gray-50 p-2 items-center rounded-lg border hover:border-rose-600">
                                            <!-- <LotAreaLogo /> -->
                                             <div class="bg-white shadow-sm rounded-full p-2">
                                                 <DocumentLogo class="w-10 h-10"/>
                                             </div>
                                            <div>
                                                <p class="text-2xl default_text-color">{{ PHPeso.format(loan_data?.equity_requirement_amount) }}</p>
                                                <p class="text-black text-sm">Equity Requirement Amount</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 bg-gray-50 p-2 items-center rounded-lg border hover:border-rose-600">
                                            <!-- <LotAreaLogo /> -->
                                             <div class="bg-white shadow-sm rounded-full p-2">
                                                 <RequestmoneyLogo class="w-10 h-10"/>
                                             </div>
                                            <div>
                                                <p class="text-2xl default_text-color capitalize">{{ loan_data?.is_income_sufficient === true ? 'Yes' : 'No' }}</p>
                                                <p class="text-black text-sm">Income Insufficient</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </MyCard>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Homeful v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
    <Teleport to="body">
    <RLIModal :show="showModal" @close-modal="showModal = false" class="block md:hidden lg:hidden xl:hidden z-20">
      <template #default>
        <div class="flex justify-between items-center border-b-2 pb-3">
          <p class="font-bold text-xl">Result</p>
          <div @click.self="showModal = false" class="bg-gray-50 px-3 py-1 rounded-full dcolor cursor-pointer">&times;</div>
        </div>
        <!-- content -->
        <div class="text-2xl grid grid-row-1 gap-4 default_text mt-2">
          <div class="">
            <div class="font-bold default_text">
              <h1 class="default_title-text">Borrower Details</h1>
            </div>
            <div class="bg-gray-50 rounded-lg grid grid-rows-1 mt-1 p-2">
              <div class="">
                <p class="text-xl">
                  <strong>{{ PHPeso.format(loan_data?.borrower?.gross_monthly_income) }}</strong></p>
                <p class="text-sm text-gray-400">Gross Monthly Income</p>
              </div>
              <div class="mt-4">
                <p class="text-xl">
                  <strong>{{ loan_data?.borrower?.birthdate }}</strong>
                </p>
                <p class="text-sm text-gray-400">Birthdate</p>
              </div>
              <div class="mt-4">
                <p class="capitalize text-xl">
                  <strong>{{ loan_data?.borrower?.regional === true ? 'Yes' : 'No' }}</strong>
                </p>
                <p class="text-sm text-gray-400">Outside NCR</p>
              </div>
            </div>
          </div>
          <div class="">
            <div class="font-bold">
              <h1 class="default_title-text">Property Details</h1>
            </div>
            <div class="bg-gray-50 grid grid-cols-2 mt-1">
              <div class="p-2">
                <div class="text-xl">
                  <p class="capitalize">
                    <strong>{{ loan_data?.property?.market_segment }}</strong>
                  </p>
                  <p class="text-sm text-gray-400">Market Segment</p>
                </div>
                <div class="mt-4">
                  <p class="text-xl">
                    <strong>{{ PHPeso.format(loan_data?.property?.total_contract_price) }}</strong>
                  </p>
                  <p class="text-sm text-gray-400">Total Contract Price</p>
                </div>
                <div class="mt-4">
                  <p class="text-xl">
                    <strong>{{ PHPeso.format(loan_data?.property?.appraised_value) }}</strong>
                  </p>
                  <p class="text-sm text-gray-400">Appraisals Value</p>
                </div>
              </div>
              <div class="p-2">
                <div class="">
                  <p class="text-xl">
                    <strong>{{ loan_data?.property?.loanable_value_multiplier * 100 }}%</strong>
                  </p>
                  <p class="text-sm text-gray-400">Loanable Multiplier</p>
                </div>
                <div class="mt-4">
                  <p class="">
                    <strong>{{ PHPeso.format(loan_data?.property?.loanable_value) }}</strong>
                  </p>
                  <p class="text-sm text-gray-400">Loanable Value</p>
                </div>
                <div class="mt-4">
                  <p class="text-xl">
                    <strong>{{ loan_data?.property?.disposable_income_requirement_multiplier * 100 }}%</strong>
                  </p>
                  <p class="text-sm text-gray-400">Disposable Income Req. Multiplier</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-2 default_text">
          <div class="font-bold">
            <h1 class="text-2xl default_title-text">Loan Details</h1>
          </div>
          <div class="mt-1">
            <div class="grid grid-cols-2 dark:text-white light:text-black gap-1 font-bold">
              <div class="flex gap-2 bg-gray-50 p-1 items-center rounded-lg border hover:border-rose-600">
                <!-- <LotAreaLogo /> -->
                <div class="bg-white shadow-sm rounded-full p-1">
                  <ReceiveCashLogo class="w-8 h-8" />
                </div>
                <div>
                  <p class="text-xl default_text-color">{{ PHPeso.format(loan_data?.loan_amount) }}</p>
                  <p class="text-black text-sm">Loan Amount</p>
                </div>
              </div>
              <div class="flex gap-2 bg-gray-50 p-1 items-center rounded-lg border hover:border-rose-600">
                <!-- <LotAreaLogo /> -->
                <div class="bg-white shadow-sm rounded-full p-1">
                  <CalendarLogo class="w-8 h-8" />
                </div>
                <div>
                  <p class="text-xl default_text-color">{{ loan_data?.months_to_pay }}</p>
                  <p class="text-black text-sm">Months to Pay</p>
                </div>
              </div>
              <div class="flex gap-2 bg-gray-50 p-1 items-center rounded-lg border hover:border-rose-600">
                <!-- <LotAreaLogo /> -->
                <div class="bg-white shadow-sm rounded-full p-1">
                  <PercentageLogo class="w-8 h-8" />
                </div>
                <div>
                  <p class="text-xl default_text-color">{{ loan_data?.annual_interest * 100 }}%</p>
                  <p class="text-black text-sm">Annual Interest</p>
                </div>
              </div>
              <div class="flex gap-2 bg-gray-50 p-1 items-center rounded-lg border hover:border-rose-600">
                <!-- <LotAreaLogo /> -->
                <div class="bg-white shadow-sm rounded-full p-1">
                  <RevenueLogo class="w-8 h-8" />
                </div>
                <div>
                  <p class="text-xl default_text-color">{{ PHPeso.format(loan_data?.joint_disposable_monthly_income) }}</p>
                  <p class="text-black text-sm">Disposable Monthly Income (Joint)</p>
                </div>
              </div>
              <div class="flex gap-2 bg-gray-50 p-1 items-center rounded-lg border hover:border-rose-600">
                <!-- <LotAreaLogo /> -->
                <div class="bg-white shadow-sm rounded-full p-1">
                  <DocumentLogo class="w-8 h-8" />
                </div>
                <div>
                  <p class="text-xl default_text-color">{{ PHPeso.format(loan_data?.monthly_amortization) }}</p>
                  <p class="text-black text-sm">Monthy Amortization</p>
                </div>
              </div>
              <div class="flex gap-2 bg-gray-50 p-1 items-center rounded-lg border hover:border-rose-600">
                <!-- <LotAreaLogo /> -->
                <div class="bg-white shadow-sm rounded-full p-1">
                  <MortgageLogo class="w-8 h-8" />
                </div>
                <div>
                  <p class="text-xl default_text-color">{{ PHPeso.format(loan_data?.equity) }}</p>
                  <p class="text-black text-sm">Equity</p>
                </div>
              </div>
              <div class="flex gap-2 bg-gray-50 p-1 items-center rounded-lg border hover:border-rose-600">
                <!-- <LotAreaLogo /> -->
                <div class="bg-white shadow-sm rounded-full p-1">
                  <DocumentLogo class="w-8 h-8" />
                </div>
                <div>
                  <p class="text-xl default_text-color">{{ PHPeso.format(loan_data?.equity_requirement_amount) }}</p>
                  <p class="text-black text-sm">Equity Requirement Amount</p>
                </div>
              </div>
              <div class="flex gap-2 bg-gray-50 p-1 items-center rounded-lg border hover:border-rose-600">
                <!-- <LotAreaLogo /> -->
                <div class="bg-white shadow-sm rounded-full p-1">
                  <RequestmoneyLogo class="w-8 h-8" />
                </div>
                <div>
                  <p class="text-xl default_text-color">{{ loan_data?.is_income_sufficient === true ? 'Yes' : 'No' }}</p>
                  <p class="text-black text-sm">Income Insufficient</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </RLIModal>
  </Teleport>
</template>

<style>
.default_text-color{
    background: linear-gradient(90deg, #CC035C 0%, #E5883C 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-fill-color: transparent;
}
.default_bg-color{
    background: linear-gradient(90deg, #CC035C 0%, #E5883C 100%);

}
.dcolor{
    color: #CC035C;
}
.default_text{
    color: #363B64
}
.default_title-text{
    color: #E5883C
}
.bg_layout{
    background: url('../../img/BGLayout.png') center no-repeat ;
    background-size: cover;
    z-index: 1;
}
</style>
