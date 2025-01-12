const app = createApp({
    setup() {
        const periods = ["Monthly", "Bi-Weekly", "Weekly"];
        const selectedPeriod = ref("Monthly");
        const payrollData = ref(window.groupedPayrolls || {}); // Pass data from Blade to JS

        // Format month-year to 'MMMM yyyy' (e.g., "January 2025")
        const formatMonthYear = (monthYear) => {
            const date = new Date(`${monthYear}-01`); // Add a day to make it a valid date
            return date.toLocaleString('default', { year: 'numeric', month: 'long' });
        };

        // Format month-year to 'yyyy-MM-dd' (e.g., "2025-01-01")
        const formatDate = (monthYear) => {
            const date = new Date(`${monthYear}-01`); // Add a day to make it a valid date
            return date.toISOString().split('T')[0]; // Convert to ISO string and return 'yyyy-MM-dd'
        };

        const filteredPayrolls = computed(() => {
            const data = payrollData.value[selectedPeriod.value];
            if (!data) return [];
            return Object.entries(data).map(([monthYear, records]) => ({
                monthYear,
                totalNetPay: records.reduce((sum, record) => sum + record.net_pay, 0),
                employeeCount: records.length,
                status: records.every((record) => record.status === "Draft") ? "Draft" : "Paid",
                date: formatDate(monthYear), // Use the native date formatting function
            }));
        });

        const setPeriod = (period) => {
            selectedPeriod.value = period;
        };

        const goToPayrollDetail = (monthYear) => {
            const url = `/payrolls/${monthYear}`;
            window.location.href = url;
        };

        const formatCurrency = (amount) =>
            new Intl.NumberFormat("en-MW", {
                style: "currency",
                currency: "MWK",
            }).format(amount);

        return {
            periods,
            selectedPeriod,
            payrollData,
            filteredPayrolls,
            setPeriod,
            goToPayrollDetail,
            formatMonthYear,
            formatCurrency,
        };
    },
});

app.mount("#app");
