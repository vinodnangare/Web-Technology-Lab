import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  email = '';
  password = '';

  constructor(private router: Router) {}

  loginUser() {
    console.log('Entered Email:', this.email);
    console.log('Entered Password:', this.password);

    let users = JSON.parse(localStorage.getItem('users') || '[]');

    let validUser = users.find((user: any) => user.email === this.email && user.password === this.password);

    if (validUser) {
      console.log('Login successful!');
      alert('Login successful! Redirecting to Dashboard.');

      this.router.navigate(['/dashboard']);
    } else {
      console.log('Invalid credentials!');
      alert('Invalid Email or Password');
    }
  }

  navigateToRegister() {
    this.router.navigate(['/register']);
  }
}
