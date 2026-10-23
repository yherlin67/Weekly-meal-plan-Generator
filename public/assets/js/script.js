// Active Tom Select sur le select id="ingredients" dans index.php et le configure 
// (plugins, placeholder, texte saisi vidé après ajout d'une étiquette)
new TomSelect('#ingredients', {
    plugins: ['remove_button'],
    placeholder: 'Tapez un ingrédient…',
    onItemAdd: function () {
        this.setTextboxValue('');
        this.refreshOptions();
    },
});