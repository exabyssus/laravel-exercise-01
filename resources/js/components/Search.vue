<template>
    <form>
        <div class="form-group">

            <input class="form-control" @input="onSearch()" v-model="searchText" type="search" name="search" />
            <br>

            <p v-if="!suppliers">Ievadiet vismaz {{ minSearchTextLength }} simbolus, lai sāktu meklēšanu</p>
            <div v-else>
                <div v-if="loading">Uzgaidiet...</div>
                <ul v-else>
                    <li v-for="organization in suppliers" :key="organization.supplierEIC">
                        {{ organization.supplierName }}
                    </li>
                </ul>

                <div v-if="!loading && suppliers.length == 0">Nekas netika atrasts</div>
            </div>
        </div>
    </form>
</template>

<script>

    // Validation constants
    const minSearchTextLength = 3;

    export default {

        data() {
            return {
                loading: false,
                searchText: null,
                suppliers: null,
                minSearchTextLength
            }
        },

        mounted() {
            // Set search query on page load if it exists
            this.searchText = this.$route.query.q;
            this.onSearch();
        },

        methods: {
            onSearch () {

                // Update query param
                if(this.searchText != this.$route.query.q) {
                    this.$root.$router.push({ name: 'search', query: { q: this.searchText }});
                }

                // Fire search if at least min chars provided
                if(this.searchText.length >= minSearchTextLength){

                    // Set loading
                    this.loading = true;

                    // Make API request
                    axios.get('/api/v1/suppliers?name=' + this.searchText)
                    .then((resp) => {
                        this.suppliers = resp.data;
                    })
                    .then(() => {
                        // Stop loading after data is set
                        this.loading = false;
                    });

                    return;
                }

                this.suppliers = null;
            }
        }
    }
</script>
