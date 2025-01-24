const app = createApp({
    setup() {
        const periods = ["Monthly", "Bi-Weekly", "Weekly"];
        const selectedPeriod = ref("Monthly");
        const payrollData = ref(validatePayrollData(window.groupedPayrolls) || {});


        const formatMonthYear = (monthYear) => {
            const [year, month] = monthYear.split("-");
            const date = new Date(year, month - 1);
            return new Intl.DateTimeFormat("en", { month: "long", year: "numeric" }).format(date);
        };

        const filteredPayrolls = computed(() => {
            const data = payrollData.value?.[selectedPeriod.value];
            if (!data) return [];
            return Object.entries(data)
                .filter(([key]) => key !== "totalNetPay")
                .map(([key, value]) => ({
                    period: key,
                    totalNetPay: value.totalNetPay || 0,
                    records: value.records || [],
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

app.mount("#appp");
