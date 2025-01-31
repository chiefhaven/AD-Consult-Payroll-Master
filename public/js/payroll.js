const app = createApp({
    setup() {
        console.log("Vue App Initialized");

        const payrollData = ref([]);

        const fetchPayrollData = async () => {
            try {
                const response = await fetch("/payrolls", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                payrollData.value = data;  // Directly assign the fetched data
                console.log("Fetched Payroll Data:", payrollData.value);
            } catch (error) {
                console.error("Error fetching payroll data:", error);
            }
        };


          // Navigate to payroll page based on period (month-year)
        const goToPayrollDetails = (period) => {
            const encodedPeriod = encodeURIComponent(period);
            window.location.href = `/payrolls/${encodedPeriod}`;
        };

        // Fetch data on initial load
        fetchPayrollData();

        const formatCurrency = (value) => {
            return new Intl.NumberFormat('en-MW', { style: 'currency', currency: 'MWK' }).format(value);
        };

        const formatMonthYear = (dateString) => {
            const options = { year: 'numeric', month: 'long' };
            return new Date(dateString).toLocaleDateString('en-MW', options);
        };

        return {
            payrollData,
            goToPayrollDetails,
            formatCurrency,
            formatMonthYear,
        };
    }
});

app.mount("#appp");
