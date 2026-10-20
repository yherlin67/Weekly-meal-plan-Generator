// Active Tom Select sur le select id="ingredients" dans index.php et le configure (plugins, placeholder)
new TomSelect('#ingredients', {
    plugins: ['remove_button'],
    placeholder: 'Tape un ingrédient…',
});