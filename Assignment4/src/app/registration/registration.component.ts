import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-registration',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.css']
})
export class RegistrationComponent {
  firstName = '';
  lastName = '';
  email = '';
  mobileNumber = '';
  password = '';

  constructor(private router: Router) {}

  registerUser() {
    if (!this.firstName || !this.lastName || !this.email || !this.mobileNumber || !this.password) {
      alert('All fields are required!');
      return;
    }

    let users = JSON.parse(localStorage.getItem('users') || '[]');

    if (users.some((user: any) => user.email === this.email)) {
      alert('Email already exists! Use a different email.');
      return;
    }

    users.push({
      firstName: this.firstName,
      lastName: this.lastName,
      email: this.email,
      mobileNumber: this.mobileNumber,
      password: this.password
    });

    localStorage.setItem('users', JSON.stringify(users));

    alert('Registration successful! Redirecting to Login.');
    this.router.navigate(['/login']);
  }

  navigateToLogin() {
    this.router.navigate(['/login']);
  }
}
