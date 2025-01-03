    document.addEventListener("DOMContentLoaded", function () {
        const eventStartInput = document.getElementById("eventStart");
        const eventEndInput = document.getElementById("eventEnd");

        // Set minimum date pada tanggal mulai agar tidak bisa pilih sebelum hari ini
        const today = new Date().toISOString().split("T")[0];
        eventStartInput.setAttribute("min", today);

        eventStartInput.addEventListener("change", function () {
            eventEndInput.setAttribute("min", eventStartInput.value);
        });

        eventEndInput.addEventListener("change", function () {
            if (eventEndInput.value < eventStartInput.value) {
                alert("Tanggal selesai tidak boleh sebelum tanggal mulai.");
                eventEndInput.value = ""; 
            }
        });

        window.addEvent = function () {
            var title = document.getElementById("eventTitle").value;
            var description = document.getElementById("eventDescription").value;
            var start = eventStartInput.value;
            var end = eventEndInput.value;

            if (title && start) {
                calendar.addEvent({
                    title: title,
                    start: start,
                    end: end ? end : start,
                    extendedProps: {
                        description: description  // Menyimpan deskripsi dalam properti tambahan
                    }
                });
                closeEventForm();
                document.getElementById("eventForm").reset();
            } else {
                alert("Judul dan tanggal mulai wajib diisi");
            }
        };
    });

    function openEventForm() {
        document.getElementById("eventForm").style.display = "block";
        document.querySelector(".modal-overlay").style.display = "block";
    }

    function closeEventForm() {
        document.getElementById("eventForm").style.display = "none";
        document.querySelector(".modal-overlay").style.display = "none";
    }

    // Fungsi untuk menampilkan detail acara
    function showEventDetails(event) {
        document.getElementById("modalEventTitle").innerText = event.title;
        document.getElementById("modalEventDescription").innerText = event.extendedProps.description || "Tidak ada deskripsi";
        document.getElementById("modalEventStart").innerText = event.start.toLocaleDateString();
        document.getElementById("modalEventEnd").innerText = event.end ? event.end.toLocaleDateString() : "Tidak ada tanggal selesai";

        document.getElementById("eventDetailModal").style.display = "block";
    }

    function showEventDetailFromReminder(title, description, startDate, endDate) {
        document.getElementById("modalEventTitle").innerText = title;
        document.getElementById("modalEventDescription").innerText = description || "Tidak ada deskripsi";
        document.getElementById("modalEventStart").innerText = new Date(startDate).toLocaleDateString();
        document.getElementById("modalEventEnd").innerText = endDate ? new Date(endDate).toLocaleDateString() : "Tidak ada tanggal selesai";

        document.getElementById("eventDetailModal").style.display = "block";
    }


    // Fungsi untuk menutup modal detail acara
    function closeEventDetailModal() {
        document.getElementById("eventDetailModal").style.display = "none";
    }

    function openEventActionModal(eventId, title, description, startDate, endDate) {
        event.stopPropagation(); // Mencegah event bubbling agar modal tidak tertutup
        const updateEventStart = document.getElementById("updateEventStart");
        const updateEventEnd = document.getElementById("updateEventEnd");
    
        // Set nilai default
        document.getElementById("updateEventId").value = eventId;
        document.getElementById("updateEventTitle").value = title;
        document.getElementById("updateEventDescription").value = description;
        updateEventStart.value = startDate;
        updateEventEnd.value = endDate;
    
        // Set batas minimum tanggal mulai
        const today = new Date().toISOString().split("T")[0];
        updateEventStart.setAttribute("min", today);
    
        // Set batas minimum tanggal selesai berdasarkan tanggal mulai
        updateEventStart.addEventListener("change", function () {
            updateEventEnd.setAttribute("min", updateEventStart.value);
        });
    
        // Validasi jika tanggal selesai kurang dari tanggal mulai
        updateEventEnd.addEventListener("change", function () {
            if (updateEventEnd.value < updateEventStart.value) {
                alert("Tanggal selesai tidak boleh sebelum tanggal mulai.");
                updateEventEnd.value = ""; // Reset nilai jika tidak valid
            }
        });
    
        // Tampilkan modal
        document.getElementById("eventActionModal").style.display = "block";
        document.querySelector(".modal-overlay").style.display = "block";
    }
    


    function closeEventActionModal() {
        document.getElementById("eventActionModal").style.display = "none";
        document.querySelector(".modal-overlay").style.display = "none";
    }


    function submitUpdate(event) {
        event.preventDefault();
    
        const id = document.getElementById("updateEventId").value;
        const title = document.getElementById("updateEventTitle").value;
        const description = document.getElementById("updateEventDescription").value;
        const startDate = document.getElementById("updateEventStart").value;
        const endDate = document.getElementById("updateEventEnd").value;
    
        // Validasi tanggal
        if (!title || !startDate) {
            alert("Judul dan tanggal mulai wajib diisi.");
            return;
        }
        if (endDate && endDate < startDate) {
            alert("Tanggal selesai tidak boleh sebelum tanggal mulai.");
            return;
        }
    
        // Kirim data ke server
        const data = {
            judul_kegiatan: title,
            deskripsi: description,
            batas_awal: startDate,
            batas_akhir: endDate
        };
    
        fetch(`${updateJadwalUrl}/${id}`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Acara berhasil diperbarui!",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        closeEventActionModal();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal memperbarui acara",
                        text: "Silakan coba lagi.",
                        showConfirmButton: true
                    });
                }
            });
    }
    


    function deleteEvent() {
        document.getElementById("confirmDeleteModal").style.display = "flex ";
    }

    function closeConfirmDeleteModal() {
        document.getElementById("confirmDeleteModal").style.display = "none";
    }

    function confirmDelete() {
        const eventId = document.getElementById("updateEventId").value;
    
        // Kirim permintaan penghapusan ke server menggunakan fetch API
        fetch(deleteJadwalUrl + '/' + eventId, {
            method: 'DELETE'
        })
        .then(response => {
            if (response.ok) {
                
                Swal.fire({
                    icon: 'success',
                    title: 'Acara berhasil dihapus!',
                    showConfirmButton: false, 
                    timer: 1500 // Notifikasi akan hilang setelah 1.5 detik
                }).then(() => {
                    // Tutup modal setelah sukses menghapus
                    closeEventActionModal();
                    closeConfirmDeleteModal();
                    location.reload(); // Refresh halaman setelah penghapusan
                });
            } else {
                // Menampilkan notifikasi gagal dengan SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menghapus acara.',
                    text: 'Silakan coba lagi.',
                    showConfirmButton: true
                });
            }
        })
        .catch(error => {
            console.error("Error:", error);
            // Menampilkan notifikasi error dengan SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan.',
                text: 'Tidak dapat menghapus acara. Silakan coba lagi.',
                showConfirmButton: true
            });
        });
    }
    
    




