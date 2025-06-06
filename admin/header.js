if (annyang) {
  function speak(text, callback) {
    const synth = window.speechSynthesis;
    const utterance = new SpeechSynthesisUtterance(text);

    utterance.onend = () => {
      if (callback) callback();
    };

    synth.speak(utterance);
  }

  function openNotifications() {
    const notifIcon = document.querySelector(".notifications .icon_wrap");
    if (notifIcon) {
      notifIcon.click();
    }
  }

  const commands = {
    "*input": (input) => {
      input = input.toLowerCase();

      //view
      if (
        (input.includes("view user") ||
          input.includes("view admin") ||
          input.includes("show info")) &&
        window.location.href.includes("adminUsers.php")
      ) {
        const normalized = input.replace(/[,\s-]+/g, ""); // remove spaces, commas, dashes
        const match = normalized.match(
          /(?:view|showinfo)(?:user|admin)?(\d+)/i
        );
        const adminId = match ? match[1] : null;

        if (adminId) {
          const infoBtn = document.querySelector(
            `[data-bs-target="#infoModal${adminId}"]`
          );
          if (infoBtn) {
            infoBtn.click();
            speak(`Showing info for user ${adminId}`);
          } else {
            speak(`I couldn't find info for user ${adminId}`);
          }
        } else {
          speak("Please say the user ID you want to view.");
        }

        return;
      }

      //delete
      if (
        (input.includes("delete user") || input.includes("delete admin")) &&
        window.location.href.includes("adminUsers.php")
      ) {
        const normalized = input.replace(/[,\s-]+/g, ""); // remove spaces and dashes
        const match = normalized.match(/delete(?:user|admin)?(\d+)/i);
        const adminId = match ? match[1] : null;

        if (adminId) {
          const deleteBtn = document.querySelector(
            `[data-bs-target="#deleteModal${adminId}"]`
          );
          if (deleteBtn) {
            deleteBtn.click();
            speak(`Deleting user ${adminId}`);
          } else {
            speak(`I couldn't find a delete button for user ${adminId}`);
          }
        } else {
          speak("Please specify the user ID to delete.");
        }

        return;
      }

      //edit
      if (
        (input.includes("edit user") || input.includes("edit admin")) &&
        window.location.href.includes("adminUsers.php")
      ) {
        const normalized = input.replace(/[,\s-]+/g, "");
        const match = normalized.match(/edit(?:user|admin)?(\d+)/i);
        const adminId = match ? match[1] : null;

        if (adminId) {
          const editBtn = document.querySelector(
            `[data-bs-target="#editModal${adminId}"]`
          );
          if (editBtn) {
            editBtn.click();
            speak(`Editing user ${adminId}`);
          } else {
            speak(`I couldn't find a user with ID ${adminId}`);
          }
        } else {
          speak("Please say the user ID you want to edit.");
        }

        return;
      }

      // Voice command to open the "Add New User" modal on adminUsers.php
      if (
        (input.includes("add new user") ||
          input.includes("create user") ||
          input.includes("open add user")) &&
        window.location.href.includes("adminUsers.php")
      ) {
        const addUserBtn = document.querySelector(
          '[data-bs-target="#addUserModal"]'
        );
        if (addUserBtn) {
          addUserBtn.click();
          speak("Opening add new user form");
        } else {
          speak("I couldn't find the add user button");
        }
        return;
      }

      // Voice command to archive enrollee by CN- ID
      if (
        input.includes("archive") &&
        window.location.href.includes("adminEnrollee.php")
      ) {
        const match = input.match(/cn[-\s]?(\d+)/i); // matches CN-6, CN 6, cn6
        const enrolleeId = match ? match[1] : null;

        if (enrolleeId) {
          const archiveBtn = document.querySelector(
            `.archive-btn[data-id="${enrolleeId}"]`
          );
          if (archiveBtn) {
            archiveBtn.click();
            speak(`Archiving enrollee CN-${enrolleeId}`);
          } else {
            speak(`Could not find enrollee with ID CN-${enrolleeId}`);
          }
        } else {
          speak("Please specify an enrollee ID like CN-6 to archive.");
        }

        return;
      }

      // Voice command to reject an applicant by name (trigger the reject button)
      if (
        input.includes("reject") &&
        window.location.href.includes("adminAdmissionManagement.php")
      ) {
        const nameMatch = input.match(/reject (applicant )?(.*)/);
        if (nameMatch && nameMatch[2]) {
          const spokenName = nameMatch[2].trim().toLowerCase();

          const rejectButtons = document.querySelectorAll(".reject-btn");
          let found = false;

          rejectButtons.forEach((button) => {
            const name = button
              .getAttribute("data-username")
              .toLowerCase()
              .replace(/\s+/g, "");
            const normalizedSpokenName = spokenName.replace(/\s+/g, "");

            if (name.includes(normalizedSpokenName)) {
              button.click();
              speak(`Rejecting ${nameMatch[2]}`);
              found = true;
            }
          });

          if (!found) {
            speak(`Sorry, I couldn't find ${nameMatch[2]}`);
          }

          return;
        }
      }

      // Open info modal by applicant name (name must be part of the modal ID)
      if (
        (input.includes("open info") || input.includes("view info")) &&
        window.location.href.includes("adminAdmissionManagement.php")
      ) {
        const nameMatch = input.match(/(?:open|view) info (?:for)? (.+)/);
        if (nameMatch && nameMatch[1]) {
          const spokenName = nameMatch[1].replace(/\s+/g, "").toLowerCase();

          const allButtons = document.querySelectorAll(
            '[data-bs-target^="#infoModal"]'
          );
          let found = false;

          allButtons.forEach((button) => {
            const target = button.getAttribute("data-bs-target"); // e.g. "#infoModalMegAngelineFabian"
            const modalId = target.replace("#infoModal", "").toLowerCase();

            if (modalId.includes(spokenName)) {
              button.click();
              speak(`Opening information for ${nameMatch[1]}`);
              found = true;
            }
          });

          if (!found) {
            speak(`Sorry, I couldn't find info for ${nameMatch[1]}`);
          }
          return;
        }
      }

      // Handle admission tab filters
      if (window.location.href.includes("adminAdmissionManagement.php")) {
        const admissionTabMap = {
          all: ["all"],
          pending: ["pending", "waiting"],
          approved: ["approved", "approve"],
          rejected: ["rejected", "denied", "declined"],
        };

        const cleanedInput = input.replace(/\s|-/g, "");

        for (const key in admissionTabMap) {
          const keywords = admissionTabMap[key];

          if (
            keywords.some((keyword) =>
              cleanedInput.includes(keyword.replace(/\s|-/g, ""))
            )
          ) {
            const tabButton = document.querySelector(`#${key}-tab`);
            if (tabButton) {
              tabButton.click();
              speak(`Switched to ${key} tab`);
            } else {
              speak(`Cannot find ${key} tab`);
            }
            return;
          }
        }
      }

      function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
      }
      //handle enrolee filters
      const tabMap = {
        all: ["all"],
        freshmen: ["freshman", "freshmen"],
        transferee: ["transferee", "transfer"],
        returnee: ["returnee", "returning"],
        nonsequential: ["nonsequential", "non sequential", "non-sequential"],
      };
      if (window.location.href.includes("adminEnrollee.php")) {
        const cleanedInput = input.replace(/\s|-/g, "");

        for (const key in tabMap) {
          const keywords = tabMap[key];

          if (
            keywords.some((keyword) =>
              cleanedInput.includes(keyword.replace(/\s|-/g, ""))
            )
          ) {
            const button = document.querySelector(
              `.filter-tab[data-type="${capitalizeFirstLetter(key)}"]`
            );
            if (button) {
              button.click();
              speak(`Showing ${capitalizeFirstLetter(key)} enrollees`);
            } else {
              speak(`Cannot find ${capitalizeFirstLetter(key)} tab`);
            }
            return;
          }
        }
      }

      //voice command for view archive and active
      if (
        input.includes("archive") &&
        window.location.href.includes("adminEnrollee.php")
      ) {
        const archiveBtn = document.getElementById("viewArchivedBtn");
        if (archiveBtn) {
          archiveBtn.click();
          speak("Showing archived enrollees");
        } else {
          speak("Cannot find archive button");
        }
        return;
      }
      if (
        input.includes("active") &&
        window.location.href.includes("adminEnrollee.php")
      ) {
        const archiveBtn = document.getElementById("viewArchivedBtn");
        if (archiveBtn) {
          archiveBtn.click();
          speak("Showing active enrollees");
        } else {
          speak("Cannot find active button");
        }
        return;
      }

      //voice command for navigations
      if (input.includes("dashboard")) {
        window.location.href = "adminDashboard.php";
        annyang.abort();
      } else if (
        input.includes("notification") ||
        input.includes("close notification")
      ) {
        openNotifications();
      } else if (input.includes("admission")) {
        window.location.href = "adminAdmissionManagement.php";
        annyang.abort();
      } else if (input.includes("logout")) {
        window.location.href = "../main/index.php";
        annyang.abort();
      } else if (input.includes("enrollee")) {
        localStorage.setItem("triggerViewArchived", "true");
        window.location.href = "adminEnrollee.php";
        annyang.abort();
      } else if (input.includes("fee")) {
        window.location.href = "adminFeeManagement.php";
        annyang.abort();
      } else if (input.includes("course")) {
        window.location.href = "adminCourseManagement.php";
        annyang.abort();
      } else if (input.includes("subject")) {
        window.location.href = "Subject_Management.php";
        annyang.abort();
      } else if (input.includes("schedule")) {
        window.location.href = "ScheduleManagement.php";
        annyang.abort();
      } else if (input.includes("user roles")) {
        window.location.href = "adminUsers.php";
        annyang.abort();
      } else if (input.includes("support inbox")) {
        window.location.href = "Support_admin.php";
        annyang.abort();
      } else if (input.includes("profile")) {
        window.location.href = "adminProfile.php";
        annyang.abort();
      } else if (input.includes("hello") || input.includes("hi")) {
        const message = `Hi ${adminName}, I'm listening. What would you like to open?`;
        speak(message);
      } else if (input.includes("goodbye")) {
        speak("Goodbye! Stopping voice control.", () => {
          annyang.abort();
          micButton.style.color = "";
          isListening = false;
        });
      } else {
        speak("Sorry, I didn't catch that.");
      }
    },
  };

  annyang.addCommands(commands);

  const micButton = document.getElementById("voiceBtn");
  const searchInput = document.getElementById("voiceSearchInput");
  let isListening = false;

  micButton.addEventListener("click", () => {
    if (!isListening) {
      annyang.start({
        autoRestart: false,
        continuous: false,
      });

      annyang.addCallback("result", function (phrases) {
        const latestPhrase = phrases[0];
        searchInput.value = latestPhrase;
        console.log("Heard:", latestPhrase);
      });

      isListening = true;
      micButton.style.color = "red";
    } else {
      annyang.abort();
      isListening = false;
      micButton.style.color = "";
    }
  });
} else {
  alert("Your browser does not support speech recognition.");
}
