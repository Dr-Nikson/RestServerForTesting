
var imagesAll = {
    "offset": "0",
    "count":
    {
        "total": "24",
        "current": "10",
        "remaining": "14"
    },
    results:
    [
        '{{repeat(24, 24)}}',
        {
            id: '{{index()+1}}',
            url: 'http://5to5admin:8888/img/works/img{{integer(1,7)}}.jpg',
            thumb: function(){
                return this.url;
            },
            alt: '{{lorem(4, "words")}}'
        }
    ]
};


var categories = [
    '{{repeat(5, 5)}}',
    {
        id: '{{objectId()}}',
        name: '{{lorem(4, "words")}}',
        children: [
            '{{repeat(1, 5)}}',
            {
                id: '{{objectId()}}',
                name: '{{lorem(4, "words")}}',
                children: [
                    '{{repeat(1, 5)}}',
                    {
                        id: '{{objectId()}}',
                        name: '{{lorem(4, "words")}}',
                        children: []
                    }
                ]
            }
        ]
    }
];