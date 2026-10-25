<!DOCTYPE html>
<html>
<body>
<script>
fetch('https://generativelanguage.googleapis.com/v1beta/models?key=AIzaSyDkdN6dbeh7sk2vdV4DAOVGUEUqPr24tFA')
.then(r => r.json())
.then(data => {
    data.models.forEach(m => {
        if (m.supportedGenerationMethods?.includes('generateContent')) {
            document.write(m.name + '<br>');
        }
    });
});
</script>
</body>
</html>