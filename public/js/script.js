$(document).ready(() => {

    function page() {
        let params = new URLSearchParams(window.location.search)

        if (params.has('page')) {
            return '&page=' + params.get('page')
        }
        return ''
    }

    async function fetch() {
        return await $.get("http://localhost/auth/api/list" + page(), function(data, status){
            window.data = data.results
            write(window.data)
        });
    }

    // write given data to page
    function write(data) {
        $('#contacts-container').html(
            data
        .map(Item).join(''));
    }

    fetch()
        .then(() => {
            feather.replace()
            $('#spinner').hide()
            $('#pagination').show()
        })

    /* Search */
    window.search = function search(e) {
        let search = e.value

        window.sData = window.data.filter(item=>
            item.name.title.toLowerCase().includes(search.toLowerCase()) ||
            item.name.first.toLowerCase().includes(search.toLowerCase()) ||
            item.name.last.toLowerCase().includes(search.toLowerCase())
        );

        write(window.sData)
    }
})