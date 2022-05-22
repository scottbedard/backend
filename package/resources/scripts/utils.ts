/**
 * Submit a post request
 */
export async function post(url = '', data = {}) {
  const response = await fetch(url, {
    body: JSON.stringify(data),
    cache: 'no-cache',
    credentials: 'same-origin',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token,
    },
    method: 'POST',
    mode: 'cors',
    redirect: 'follow',
    referrerPolicy: 'no-referrer',
  });

  return response.json();
}

/**
 * Cross-site request forgery token
 */
 export const token = document.querySelector('meta[name="csrf-token"]')!.getAttribute('content')!
