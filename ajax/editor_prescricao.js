    $('#editorprescricao').summernote({
        height: 200,
        placeholder: 'digite o atalho começando com @ with apple, orange, watermelon and lemon',
        hint: { // trata-se de um JSON com os atalhos (poderá vir de um ajax... montar AJAX aqui mesmo na função)
            mentions: <?php require 'ajax/get_presc_preferidas_ajax.php';?>,
            match: /\B\[\[(\w*)$/,
            search: function (keyword, callback) {
                callback($.grep(this.mentions, function (item) {
                    return item.name.indexOf(keyword) == 0;
                }));
            },
            template: function (item) {
                return item.name;
            },
            content: function (item) { // Modela o que vai retornar no próprio editor
                return $('<x>'+item.descricao+'</x>')[0];
            }
        }
    });