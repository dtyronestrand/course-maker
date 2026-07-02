sed -i 's/const styleByStatus = (status: string) => {//g' resources/js/components/LeadDashboard.vue
sed -i 's/    switch(status){//g' resources/js/components/LeadDashboard.vue
sed -i 's/        case '\''pending'\'':/ /g' resources/js/components/LeadDashboard.vue
sed -i 's/            return '\''bg-yellow-500\/20 text-yellow-400 border-yellow-400\/50'\'';/ /g' resources/js/components/LeadDashboard.vue
sed -i 's/        case '\''design'\'':/ /g' resources/js/components/LeadDashboard.vue
sed -i 's/            return '\''bg-blue-500\/20 text-blue-400 border-blue-400\/50'\'';/ /g' resources/js/components/LeadDashboard.vue
sed -i 's/        case '\''completed'\'':/ /g' resources/js/components/LeadDashboard.vue
sed -i 's/            return '\''bg-green-500\/20 text-green-400 border-green-400\/50'\'';/ /g' resources/js/components/LeadDashboard.vue
sed -i 's/        default:/ /g' resources/js/components/LeadDashboard.vue
sed -i 's/            return '\''bg-gray-500\/20 text-gray-400 border-gray-400\/50'\'';/ /g' resources/js/components/LeadDashboard.vue
sed -i '143d' resources/js/components/LeadDashboard.vue
sed -i '143d' resources/js/components/LeadDashboard.vue
