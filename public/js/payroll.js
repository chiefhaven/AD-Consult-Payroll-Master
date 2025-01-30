const { createApp, ref, watch, computed } = Vue;

const app = createApp({
    setup() {
        console.log("Vue App Initialized");

        const periods = [ "All","Monthly", "Bi-Weekly","Weekly" ];
        const selectedPeriod = ref(window.selectedFilter || "All");
        const payrollData = ref([]);
        const totalNetPay = ref(0);
        const currentPage = ref(1);
        const lastPage = ref(1);

        const fetchPayrollData = async (page = 1, period = "All") => {
            try {
                const response = await fetch(`/payrolls?page=${page}&filter=${period}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                payrollData.value = data.data;
                console.log(payrollData.value);
                totalNetPay.value = data.totalNetPay;
                currentPage.value = data.currentPage;
                lastPage.value = data.lastPage;
            } catch (error) {
                console.error("Error fetching payroll data:", error);
            }
        };

        // Fetch data on initial load
        fetchPayrollData(currentPage.value, selectedPeriod.value);

        // Watch the selected period
        watch(selectedPeriod, (newPeriod) => {
            fetchPayrollData(currentPage.value, newPeriod);
        });

        // Pagination methods
        const nextPage = () => {
            if (currentPage.value < lastPage.value) {
                fetchPayrollData(currentPage.value + 1, selectedPeriod.value);
            }
        };

        const prevPage = () => {
            if (currentPage.value > 1) {
                fetchPayrollData(currentPage.value - 1, selectedPeriod.value);
            }
        };

        // Computed property
        const filteredPayrolls = computed(() => {
            return payrollData.value;
        });

        return {
            periods,
            fetchPayrollData,
            selectedPeriod,
            payrollData,
            filteredPayrolls,
            totalNetPay,
            currentPage,
            lastPage,
            nextPage,
            prevPage,

        };
    }
});

app.mount("#appp");
