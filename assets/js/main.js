
const grid = Vue.component('table-grid', {
    template: '#grid-template',
    props: {
        data: Array,
        columns: Array,
        filterKey: String
    },
    data: function () {
        var sortOrders = {}
        this.columns.forEach(function (key) {
            sortOrders[key] = 1
        })
        return {
            sortKey: '',
            sortOrders: sortOrders
        }
    },
    computed: {
        filteredData: function () {
            var sortKey = this.sortKey
            var filterKey = this.filterKey && this.filterKey.toLowerCase()
            var order = this.sortOrders[sortKey] || 1
            var data = this.data

            return data
        }
    },
    filters: {
        capitalize: function (str) {
            return str.charAt(0).toUpperCase() + str.slice(1)
        }
    },
    methods: {
        sortBy: function (key) {
            this.sortKey = key
            this.sortOrders[key] = this.sortOrders[key] * -1
        }
    }
})
var demo = new Vue({
    el: '#demo',
    data: {
        search: '',
        gridColumns: ['name', 'country', 'rating', 'is_active'],
        gridData: null,
        result: "",
        country: null,
        is_active: null,
        avg_rating: 0,
        max_rating: 0,
        max_rating_user_name: ""
    },
    created: function () {
        this.fetchData()
    },

    methods: {
        fetchData: function (url = "/get-all") {
            var self = this;
            $.get( url , function( data ) {
                if (data.length == 0) {
                    self.result = "Ничего не найдено";
                    self.avg_rating = 0;
                    self.max_rating = 0;
                    self.max_rating_user_name = 0;
                } else {
                    const max = data.reduce((prev, current) => (parseInt(prev.rating) > parseInt(current.rating)) ? prev : current);
                    data = data.map(function (x) {
                        if (x.name == max.name) {
                            x.max = true;
                        }
                        return x;
                    });
                    self.max_rating = max.rating;
                    self.max_rating_user_name = max.name;
                    self.avg_rating = Math.round(data.reduce((sum, current) => sum + parseInt(current.rating), 0) / data.length);
                    self.result = "";
                }
                self.gridData = data;

            });
        },
        updateData: function () {

            var self = this;

            if (self.country == null && self.is_active == null) {
                this.fetchData();
            } else {
                let query = "/get-users-filtered?";
                if (self.country != null) {
                    query += "country="+self.country;
                }
                if (self.is_active != null) {

                    query += "&isActive="+self.is_active;
                }
                this.fetchData(query);
            }

        }
    }
})


var example1 = new Vue({
    el: '#example-1',
    data: {
        items: []
    },
    created() {
        fetch("/get-countries")
            .then(response => response.json())
            .then(json => {this.items = json})
    },
    methods: {
        update: function (event) {

            demo[$(event.target).attr("name")] = $(event.target).val() == 0 ? null : $(event.target).val();
            demo.updateData();
        }
    }
})
