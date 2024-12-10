<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
// isAdmin();

$select = mysqli_query($con, "SELECT * FROM homepage_data");
$row = mysqli_fetch_array($select);

if (isset($_REQUEST['submit'])) {
    // Collecting form data
    $textInput1 = $_POST['textInput1'];
    $editableInput1 = $_POST['editableInput1'];
    $editableInput2 = $_POST['editableInput2'];

    // Handle file uploads
    $imageInput1 = isset($_FILES['imageInput1']) ? $_FILES['imageInput1'] : null;
    $imageInput2 = isset($_FILES['imageInput2']) ? $_FILES['imageInput2'] : null;
    $imageInput3 = isset($_FILES['imageInput3']) ? $_FILES['imageInput3'] : null;

    // Validation: Check if required fields are filled
    if (empty($textInput1) || empty($editableInput1) || empty($editableInput2)) {
        echo "<div class='alert alert-danger'>Please fill in all the required fields.</div>";
    } else {
        // Process file uploads
        $uploadDir = '../image/';
        $imagePaths = [];

        // Handle image 1 upload
        if ($imageInput1 && $imageInput1['error'] == 0) {
            $imagePath1 = $uploadDir . basename($imageInput1['name']);
            if (move_uploaded_file($imageInput1['tmp_name'], $imagePath1)) {
                $imagePaths[0] = $imagePath1;
            } else {
                echo "<div class='alert alert-danger'>Error uploading image 1.</div>";
            }
        } elseif (empty($imageInput1)) {
            $imagePaths[0] = $row['image1_path']; // Keep the old image if not replaced
        }

        // Handle image 2 upload
        if ($imageInput2 && $imageInput2['error'] == 0) {
            $imagePath2 = $uploadDir . basename($imageInput2['name']);
            if (move_uploaded_file($imageInput2['tmp_name'], $imagePath2)) {
                $imagePaths[1] = $imagePath2;
            } else {
                echo "<div class='alert alert-danger'>Error uploading image 2.</div>";
            }
        } elseif (empty($imageInput2)) {
            $imagePaths[1] = $row['image2_path']; // Keep the old image if not replaced
        }

        // Handle image 3 upload
        if ($imageInput3 && $imageInput3['error'] == 0) {
            $imagePath3 = $uploadDir . basename($imageInput3['name']);
            if (move_uploaded_file($imageInput3['tmp_name'], $imagePath3)) {
                $imagePaths[2] = $imagePath3;
            } else {
                echo "<div class='alert alert-danger'>Error uploading image 3.</div>";
            }
        } elseif (empty($imageInput3)) {
            $imagePaths[2] = $row['image3_path']; // Keep the old image if not replaced
        }

        // Ensure paths are set for all images, even if not uploaded
        $image1Path = $imagePaths[0] ?? $row['image1_path'];
        $image2Path = $imagePaths[1] ?? $row['image2_path'];
        $image3Path = $imagePaths[2] ?? $row['image3_path'];

        // Update the database with the new values
        $query = "UPDATE homepage_data
                  SET text_input1 = '$textInput1',
                      editable_input1 = '$editableInput1',
                      editable_input2 = '$editableInput2',
                      image1_path = '$image1Path',
                      image2_path = '$image2Path',
                      image3_path = '$image3Path'
                  WHERE id = " . $row['id'];

        // Execute the query
        if (mysqli_query($con, $query)) {
            // Refresh the page using JavaScript
            echo "<script>window.location.href='home';</script>";
        } else {
            echo "<div class='alert alert-danger'>Error updating data in the database: " . mysqli_error($con) . "</div>";
        }
    }
}

?>

<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<style>
    /* Hide the default file input */
    .custom-file-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    .custom-file-input-container {
        position: relative;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Manage Homepage</h4>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <!-- First Section -->
                    <div class="mb-4">
                        <h5 class="underline">Section 1</h5>
                        <div class="form-group mb-3">
                            <label for="textInput1">Heading</label>
                            <input type="text" id="textInput1" name="textInput1" class="form-control" placeholder="Enter text" value="<?= $row['text_input1'] ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="quillEditor1">Text</label>
                            <div id="quillEditor1" style="min-height: 100px; border: 1px solid #ced4da;"><?= $row['editable_input1'] ?></div>
                            <input type="hidden" name="editableInput1" id="editableInput1" value="">
                        </div>
                        <div class="form-group mb-3 d-flex align-items-center">
                            <div>
                                <label for="imageInput1">Image 1</label>
                                <div class="custom-file-input-container">
                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('imageInput1').click();">Choose Image</button>
                                    <input type="file" id="imageInput1" name="imageInput1" class="custom-file-input" accept="image/*">
                                </div>
                            </div>
                            <div id="previewImage1" class="ms-3" style="margin-left: 20px;">
                                <?php
                                if ($row['image1_path'] !== '') {
                                ?>
                                    <img src="<?= $row['image1_path'] ?>" alt="Selected Image" style="max-width: 100px; max-height: 100px; border: 1px solid #ccc;">
                                <?php
                                } else {
                                ?>
                                    <p>No image selected</p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group mb-3 d-flex align-items-center">
                            <div>
                                <label for="imageInput2">Image 2</label>
                                <div class="custom-file-input-container">
                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('imageInput2').click();">Choose Image</button>
                                    <input type="file" id="imageInput2" name="imageInput2" class="custom-file-input" accept="image/*">
                                </div>
                            </div>
                            <div id="previewImage2" class="ms-3" style="margin-left: 20px;">
                                <?php
                                if ($row['image2_path'] !== '') {
                                ?>
                                    <img src="<?= $row['image2_path'] ?>" alt="Selected Image" style="max-width: 100px; max-height: 100px; border: 1px solid #ccc;">
                                <?php
                                } else {
                                ?>
                                    <p>No image selected</p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Second Section -->
                    <div class="mb-4">
                        <h5>Section 2</h5>
                        <div class="form-group mb-3">
                            <label for="quillEditor2">Text</label>
                            <div id="quillEditor2" style="min-height: 100px; border: 1px solid #ced4da;"><?= $row['editable_input2'] ?></div>
                            <input type="hidden" name="editableInput2" id="editableInput2" value="">
                        </div>
                        <div class="form-group mb-3 d-flex align-items-center">
                            <div>
                                <label for="imageInput3">Image</label>
                                <div class="custom-file-input-container">
                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('imageInput3').click();">Choose Image</button>
                                    <input type="file" id="imageInput3" name="imageInput3" class="custom-file-input" accept="image/*">
                                </div>
                            </div>
                            <div id="previewImage3" class="ms-3" style="margin-left: 20px;">
                                <?php
                                if ($row['image3_path'] !== '') {
                                ?>
                                    <img src="<?= $row['image3_path'] ?>" alt="Selected Image" style="max-width: 100px; max-height: 100px; border: 1px solid #ccc;">
                                <?php
                                } else {
                                ?>
                                    <p>No image selected</p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Quill editor for both sections
    var quill1 = new Quill('#quillEditor1', {
        theme: 'snow',
        placeholder: 'Enter your content here...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                ['link']
            ]
        }
    });
    var quill2 = new Quill('#quillEditor2', {
        theme: 'snow',
        placeholder: 'Enter your content here...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                ['link']
            ]
        }
    });

    // Set hidden input values before submitting the form
    document.querySelector("form").onsubmit = function() {
        document.getElementById('editableInput1').value = quill1.root.innerHTML;
        document.getElementById('editableInput2').value = quill2.root.innerHTML;
    };
    // Function to update the preview when a new image is selected
    function updateImagePreview(inputId, previewId) {
        const fileInput = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewId);
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Selected Image" style="max-width: 100px; max-height: 100px; border: 1px solid #ccc;">';
            };
            reader.readAsDataURL(file);
        }
    }

    // Event listeners for image inputs
    document.getElementById('imageInput1').addEventListener('change', function () {
        updateImagePreview('imageInput1', 'previewImage1');
    });

    document.getElementById('imageInput2').addEventListener('change', function () {
        updateImagePreview('imageInput2', 'previewImage2');
    });

    document.getElementById('imageInput3').addEventListener('change', function () {
        updateImagePreview('imageInput3', 'previewImage3');
    });
</script>

<?php
include 'footer.php';
?>