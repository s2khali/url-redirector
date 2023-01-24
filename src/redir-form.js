// In a bigger project, throw this in a different folder and host in CDN for load times

let existingTable;

// Initialize event listener
window.onload = () => {
	existingTable = document.getElementById("existing-table");

    document.getElementById("custom-form").addEventListener("submit", submitForm);
    document.getElementById("random-form").addEventListener("submit", submitForm);

	let deleteBtns = document.getElementsByClassName("remove-row");

	for (let i = 0; i < deleteBtns.length; i++) {
		deleteBtns[i].addEventListener("click", removeRow);
	}
}


const submitForm = (event) => {
    event.preventDefault();

    let data = new FormData(event.target);
    let formObj = serialize(data);

    axios.post('/submit.php', formObj)
        .then(function (res) {
			let response = res.data;
			let responseElement = event.target.querySelector('.form-response');

			if(response.result === 'exists') {
				// Show that it exists
				responseElement.textContent = "Shortened URL already exists!";
			} else if (response.result === 'params') {
				// Invalid form
				responseElement.textContent = "Missing Parameters!";
			} else if (response.result === 'success') {
				// Saved!
				responseElement.textContent = "Success!";
				let route = response.route || null;
				addRow(formObj, route);
			}
        })
        .catch(function (err) {
            console.log(err);
        })
}

const serialize = (data) => {
	let obj = {};
	for (let [key, value] of data) {
		if (obj[key] !== undefined) {
			if (!Array.isArray(obj[key])) {
				obj[key] = [obj[key]];
			}
			obj[key].push(value);
		} else {
			obj[key] = value;
		}
	}
	return obj;
}

const removeRow = (event) => {
	let key = event.target.getAttribute('data-key');

	axios.post('/remove.php', {"key": key})
        .then(function (res) {
			event.target.parentElement.remove();
        })
        .catch(function (err) {
            console.log(err);
        })
}

// Add a new row and make sure the remove listener is added
const addRow = (data, route) => {
	let shortURL = route || data['url-short'];

	let rowFragment = `
        <tr>
            <td><a href="${data['url-long']}">${data['url-long']}</a></td>
            <td><a href="${shortURL}">${shortURL}</a></td>
            <td class="remove-row" data-key="${shortURL}">&times;</td>
        </tr>
	`;

	existingTable.insertAdjacentHTML('beforeend',rowFragment);

	document.querySelector(`.remove-row[data-key="${shortURL}"]`).addEventListener("click", removeRow);
}
