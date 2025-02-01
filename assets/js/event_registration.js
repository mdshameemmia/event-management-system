let clickCount = 0;
let previousData = "";

function getHeadingValue(data) {
  console.log(data,'test')
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
  loadEventRegistration(1, data, orderBy);
}

function loadEventRegistration(page = 1, sortBy = "", orderBy = "", key = "") {
  sortBy = sortBy.length == 0 ? "registrationdate" : sortBy;
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
    console.log(xhr,'test xhr')
    if (xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      console.log(response);
      displayEventRegistration(response.eventRegistrations);
      displayPagination(response.total, page);
    }
  };
  xhr.send();
}

function displayEventRegistration(events) {
  console.log(events, "events");
  let tableBody = document.getElementById("event_registration_list");
  tableBody.innerHTML = "";

  events.forEach((event) => {
    let formattedDate = new Date(event.registrationdate).toLocaleDateString();
    let row = `<tr>
                <td>${event.id}</td>
                <td>${event.name}</td>
                <td>${event.email}</td>
                <td>${event.mobile}</td>
                <td>${formattedDate}</td>
                <td>${event.address}</td>
                <td>${event.eventname}</td>
                <td class="d-flex">
                        <form action="delete.php" method="POST">
                            <input type="hidden" name="id" value="${event.id}">
                            <button type="submit" onclick="return confirm('Are you sure want to delete ?')" class="btn btn-danger btn-rounded">Delete</button>
                        </form>
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
  link += `<a href="#" onclick="loadEventRegistration(${
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
      link += `<a href="#" onclick="loadEventRegistration(${i})"><button class="btn btn-outline-success btn-white btn-outline ${
        page === i ? "active" : ""
      }">${i}</button></a>`;
    }
  }
  link += `<a href="#" onclick="loadEventRegistration(${
    page + 1
  })"><button class="btn btn-outline-success btn-white btn-outline" ${
    page == totalPages ? "disabled" : ""
  }>Next</button></a>`;
  pagination.innerHTML += link;
}

function globalSearch(data){
  loadEventRegistration(1, "", "", data.value);
}




document.addEventListener("DOMContentLoaded", function () {
  loadEventRegistration();
});
