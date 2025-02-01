let clickCount = 0;
let previousData = "";

function getHeadingValue(data) {
  console.log(data, clickCount, previousData);
  document
    .querySelectorAll(`.all-up`)
    .forEach((item) => item.classList.add("d-none"));
  document
    .querySelectorAll(`.all-down`)
    .forEach((item) => item.classList.add("d-none"));

  let orderBy = "";
  if (clickCount % 2 === 0 && previousData === data) {
    orderBy = "asc";
    document
      .querySelector(`.down-icon-${data}`)
      .setAttribute("class", `all-down down-icon-${data}`);
    document
      .querySelector(`.up-icon-${data}`)
      .setAttribute("class", `d-none all-up up-icon-${data}`);
    clickCount++;
  } else {
    orderBy = "desc";
    document
      .querySelector(`.up-icon-${data}`)
      .setAttribute("class", `all-up up-icon-${data}`);
    document
      .querySelector(`.down-icon-${data}`)
      .setAttribute("class", `d-none all-down down-icon-${data}`);
    clickCount = 0;
  }

  previousData = data;
  loadEvents(1, data, orderBy);
}

function loadEvents(page = 1, sortBy = "", orderBy = "", key = "") {
  sortBy = sortBy.length == 0 ? "startdate" : sortBy;
  sortOrder = orderBy.length == 0 ? "asc" : orderBy;

  let limit = 5;
  let offset = (page - 1) * limit;

  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `list_by_ajax.php?limit=${limit}&offset=${offset}&sort_by=${sortBy}&sort_order=${sortOrder}&key=${key}`,
    true
  );
  xhr.onload = function () {
    if (xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      console.log(response);
      displayEvents(response.events);
      displayPagination(response.total, page);
    }
  };
  xhr.send();
}

function displayEvents(events) {
  let tableBody = document.getElementById("eventList");
  tableBody.innerHTML = "";

  events.forEach((event) => {
    let row = `<tr>
                <td>${event.id}</td>
                <td>${event.name}</td>
                <td>${event.description}</td>
                <td>${event.startdate}</td>
                <td>${event.enddate}</td>
                <td>${event.location}</td>
                <td>${event.status}</td>
                <td class="d-flex">
                        <a href="edit.php?id=${event.id}"><button type="button" class="mx-2 btn btn-primary btn-sm btn-rounded">Edit</button></a>
                        <form action="delete.php" method="POST">
                            <input type="hidden" name="id" value="${event.id}">
                            <button type="submit" onclick="return confirm('Are you sure want to delete ?')" class="btn btn-danger btn-rounded">Delete</button>
                        </form>
                        <button class='btn text-info' id='id_${event.id}' onclick='copyLinkBtn(${event.id})'>Copy Link</button>
                       
                    </td>
            </tr>`;
    tableBody.innerHTML += row;
  });
}

function displayPagination(total, page) {
  let pagination = document.getElementById("pagination");
  pagination.innerHTML = "";
  let totalPages = Math.ceil(total / 5);

  let link = "";
  link += `<a href="#" onclick="loadEvents(${
    page - 1
  })"><button class="btn btn-outline-success btn-white btn-outline " ${
    page == 1 ? "disabled" : ""
  }>Previous</button></a>`;
  for (let i = 1; i <= totalPages; i++) {
    if (page + 2 < i) {
      link += "...";
    } else if (page - 2 > i) {
      link += "...";
    } else {
      link += `<a href="#" onclick="loadEvents(${i})"><button class="btn btn-outline-success btn-white btn-outline ${
        page === i ? "active" : ""
      }">${i}</button></a>`;
    }
  }
  link += `<a href="#" onclick="loadEvents(${
    page + 1
  })"><button class="btn btn-outline-success btn-white btn-outline" ${
    page == totalPages ? "disabled" : ""
  }>Next</button></a>`;
  pagination.innerHTML += link;
}

function globalSearch(data){
  loadEvents(1, "", "", data.value);
}

function copyLinkBtn(id) {

  let encodedId = btoa(id);
  let link = `http://localhost/event-management-system/public/frontend/event_registration_form.php?id=${encodedId}`;
  navigator.clipboard.writeText(link);
  document.getElementById(`id_${id}`).innerHTML = "Link Copied";
}


document.addEventListener("DOMContentLoaded", function () {
  loadEvents();
});


