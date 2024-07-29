<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic JSON Tree with jsTree</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css">
    <style>
        #tree {
            margin-top: 20px;
        }

        #json-input {
            margin-bottom: 20px;
            width: 100%;
            height: 150px;
        }
    </style>
</head>

<body>

    <h1>Dynamic JSON Tree Viewer</h1>

    <textarea id="json-input" placeholder='Masukkan data JSON di sini...'></textarea>
    <button onclick="updateTree()">Update Tree</button>

    <div id="tree"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
    <script>
        // Initialize jsTree with empty data
        $('#tree').jstree({
            'core': {
                'data': []
            }
        });

        // Function to convert JSON to jsTree format
        function convertToJsTreeFormat(data) {
            return data.map(item => {
                const children = Object.entries(item).map(([key, value]) => {
                    if (typeof value === 'object' && value !== null && !Array.isArray(value)) {
                        return {
                            text: key,
                            children: convertToJsTreeFormat([value])
                        };
                    } else {
                        return {
                            text: `${key}: ${value}`
                        };
                    }
                });

                return {
                    text: item.nama,
                    children: children
                };
            });
        }

        // Function to update the tree with JSON data from textarea
        function updateTree() {
            try {
                // Get JSON data from textarea
                const jsonData = JSON.parse(document.getElementById('json-input').value);

                // Convert JSON data to jsTree format
                const jsTreeData = convertToJsTreeFormat(jsonData);

                // Update jsTree with new data
                const treeInstance = $('#tree').jstree(true);
                treeInstance.settings.core.data = jsTreeData;
                treeInstance.refresh();

                // Open all nodes after tree is refreshed
                $('#tree').on('loaded.jstree', function() {
                    $('#tree').jstree(true).open_all(); // Automatically open all nodes
                });

            } catch (e) {
                alert('Invalid JSON data. Please check your input.');
                console.error(e); // Print error to console for debugging
            }
        }
    </script>

</body>

</html>