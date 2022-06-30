$(document).ready(() => {

    // get page number from url
    function page() {
        let params = new URLSearchParams(window.location.search)

        if (params.has('page')) {
            return '&page=' + params.get('page')
        }
        return ''
    }

    window.fetch = async function() {
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

    // search
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