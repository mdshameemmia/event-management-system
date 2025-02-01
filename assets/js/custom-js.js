setTimeout(() => {
  const alertMsgs = document.querySelectorAll('.alert-msg');
  if (alertMsgs.length > 0) {
    alertMsgs.forEach(alertMsg => alertMsg.remove()); 
  }
  sessionStorage.removeItem('alertMsg'); 
}, 5000);