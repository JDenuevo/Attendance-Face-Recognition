const video = document.getElementById("video");
const overlay = document.getElementById("canvas");

Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("../FaceRecognition/models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("../FaceRecognition/models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("../FaceRecognition/models"),
])
.then(startWebcam)
.then(faceRecognition);

function startWebcam() {
  return navigator.mediaDevices
  .getUserMedia({
    video: { facingMode: "user" },
    audio: false,
  })
  .then((stream) => {
    video.srcObject = stream;
    return new Promise((resolve) => {
      video.onloadedmetadata = () => {
        const displaySize = {
          width: video.videoWidth,
          height: video.videoHeight,
        };
        faceapi.matchDimensions(overlay, displaySize);
        overlay.width = video.videoWidth;
        overlay.height = video.videoHeight;
        resolve();
      };
    });
  });
}

async function getLabeledFaceDescriptors() {
    try {
      const folderNames = await fetch('../E_FaceRecognition/folder_names.php')
        .then(response => response.json());
  
      const labeledFaceDescriptors = await Promise.all(
        folderNames.map(async (labelName) => {
          const descriptions = [];
          const labelImageFiles = await fetch(`../FaceRecognition/labels/${labelName}`)
            .then(response => response.text())
            .then(html => {
              const parser = new DOMParser();
              const dom = parser.parseFromString(html, 'text/html');
              const links = Array.from(dom.querySelectorAll('a'));
              const imageLinks = links.filter(link => link.getAttribute("href").endsWith(".png") ||
              link.getAttribute("href").endsWith(".jpg"));
              return imageLinks.map(link => link.getAttribute('href'));
            });
  
          for (let i = 0; i < labelImageFiles.length; i++) {
            const img = await faceapi.fetchImage(`../FaceRecognition/labels/${labelName}/${labelImageFiles[i]}`);
            const detection = await faceapi
              .detectSingleFace(img)
              .withFaceLandmarks()
              .withFaceDescriptor();
            if (detection) {
              descriptions.push(detection.descriptor);
            }
          }
  
          if (descriptions.length === 0) {
            console.log(`No face descriptors found for label '${labelName}'.`);
          }
  
          return new faceapi.LabeledFaceDescriptors(labelName, descriptions);
        })
      );
  
      return labeledFaceDescriptors.filter(
        descriptor => descriptor.descriptors.length > 0
      );
    } catch (error) {
      console.error(error);
    }
  }
  
  async function faceRecognition() {
    const labeledFaceDescriptors = await getLabeledFaceDescriptors();
    if (labeledFaceDescriptors.length === 0) {
      console.log(labeledFaceDescriptors);
      return;
    }
    const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);
  
    video.addEventListener("playing", () => {
      location.reload();
    });
  
    let lastSubmissionTime = null;

    setInterval(async () => {
      const detections = await faceapi
        .detectAllFaces(video)
        .withFaceLandmarks()
        .withFaceDescriptors();
    
      const displaySize = { width: video.videoWidth, height: video.videoHeight };
      faceapi.matchDimensions(overlay, displaySize);
      overlay.width = video.videoWidth;
      overlay.height = video.videoHeight;
    
      const resizedDetections = faceapi.resizeResults(detections, displaySize);
    
      overlay.getContext("2d").clearRect(0, 0, overlay.width, overlay.height);
    
      const results = resizedDetections.map((d) => {
        return faceMatcher.findBestMatch(d.descriptor);
      });
    
      results.forEach((result, i) => {
        const box = resizedDetections[i].detection.box;
        const drawBox = new faceapi.draw.DrawBox(box, {
          label: result,
        });
        drawBox.draw(overlay);
    
        // Insert data into database if user is recognized with confidence >=57%
        if (result._label !== "unknown" && result._distance >= 0.56) {
          const currentTime = new Date();
    
          // Check if enough time has elapsed since the last submission
          if (lastSubmissionTime === null || currentTime - lastSubmissionTime >= 20000) {
            lastSubmissionTime = currentTime;
    
            const name = result._label;
            const now = new Date();
            const options = { timeZone: 'Asia/Manila' };
            const date = now.toLocaleString('en-US', options).split(' ')[0];
            const time_in = now.toLocaleString('en-US', options).split(' ')[1];
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const image = canvas.toDataURL('image/jpeg', 0.8);
            const data = { name, date, time_in, image };
    
            if (typeof jQuery === 'undefined') {
              console.error('jQuery is not loaded.');
            } else {
              $.ajax({
                type: "POST",
                url: "../E_FaceRecognition/insert_data.php",
                data: data,
                success: function (response) {
                  $('h3').html(response); // Update the content of <h3> element with the response
                },
              });
            }
          }
        }
      });
    }, 100);
  }