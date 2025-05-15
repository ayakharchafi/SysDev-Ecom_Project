document.addEventListener("DOMContentLoaded", () => {
  
    const importBtn = document.getElementById("importbutton");  
    if (!button) {
        console.error("Button not found!");
        return;
      }
    importBtn.addEventListener("click", async function () {
     
      const client = document.getElementById("clientSelect").value;
      const fileInput = document.getElementById("csvFile");
      const file = fileInput.files[0];
   
      if (!client || !file) {
        alert("Please select both client and a CSV file.");
        return;
      }
  
      const formData = new FormData();
      formData.append("client", client);
      formData.append("csv", file);
  
      try {
        const response = await fetch("/tern_app/SysDev-Ecom_Project/import.php", {
          method: "POST",
          body: formData,
        });
  
        const result = await response.text();
        alert(result);
      } catch (error) {
        console.error("Upload failed:", error);
        alert("An error occurred while uploading.");
      }
    });
  });