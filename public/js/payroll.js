const app = createApp({
    setup() {
        console.log("Vue App Initialized");

        const periods = ["Monthly", "Weekly", "Bi-Weekly", "All"];
        const selectedPeriod = ref(window.selectedFilter || "All"); // Use the filter passed from the controller
        const payrollData = ref([]);
        const totalNetPay = ref(0);
        const currentPage = ref(1);
        const lastPage = ref(1);

        // Fetch payroll data from the server (returns JSON)
        const fetchPayrollData = async (page = 1, period = "All") => {
            try {
                const response = await fetch(`/api/payrolls?page=${page}&filter=${period}`);
                const data = await response.json();

                payrollData.value = data.data;
                totalNetPay.value = data.totalNetPay;
                currentPage.value = data.currentPage;
                lastPage.value = data.lastPage;
            } catch (error) {
                console.error("Error fetching payroll data:", error);
            }
        };

        // Fetch data on initial load
        fetchPayrollData(currentPage.value, selectedPeriod.value);

        // Watch the selected period and fetch new data based on the selected period
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

        return {
            periods,
            selectedPeriod,
            payrollData,
            totalNetPay,
            currentPage,
            lastPage,
            nextPage,
            prevPage,
        };
    },
});

app.mount("#appp");
