<div class="modal fade" id="update_user{{ $user->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white fw-bold">
                <p class="modal-title" id="exampleModalLabel">Editar información usuario</p>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('usuarios.update', ['usuario' => $user->id]) }}" enctype="multipart/form-data" novalidate autocomplete="off">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="customer" id="customer_{{ $user->id }}" value="{{ $user->customer }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-12 mb-sm-0">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name_{{ $user->id }}"
                                                name="name_{{ $user->id }}" value="{{ $user->name }}"
                                                maxlength="40"
                                                style="text-transform: uppercase;">
                                            <label for="name" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-sm-0">
                                        <div class="form-floating">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email_{{ $user->id }}"
                                                name="email" value="{{ $user->email }}">
                                            <label for="email" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-sm-0">
                                        <div class="form-floating">
                                            <input id="telephone_{{ $user->id }}" name="telephone" type="text"
                                                class="form-control @error('telephone') is-invalid @enderror" value="{{ $user->telephone }}" maxlength="8">
                                            <label for="telephone" class="form-label">Teléfono</label>
                                            @error('telephone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12 mb-sm-0">
                                        <select class="tom-select @error('type') is-invalid @enderror"
                                            id="type_{{ $user->id }}" name="type">
                                            <option value="" selected disabled>Seleccione el tipo de empleado</option>
                                            <option value="Empleado" {{ (old('type') ?? $user->type) == 'Empleado' ? 'selected' : '' }}>Empleado</option>
                                            <option value="Administrador" {{ (old('type') ?? $user->type) == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                        </select>
                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-sm-0">
                                        <div class="form-floating">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_{{ $user->id }}"
                                                name="password">
                                            <label for="password">Contraseña <span class="text-danger">*</span></label>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-sm-0">
                                        <div class="form-floating input-group">
                                            <input id="password-confirm_{{ $user->id }}" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror">
                                            <label for="confirm" class="form-label">Confirmar contraseña <span class="text-danger">*</span></label>
                                            <button type="button" id="show_password_{{ $user->id }}" class="btn btn-dark" onclick="fShowPassword()">
                                                <span class="fa fa-eye-slash icon"></span>
                                            </button>
                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product presentation card -->
                            <div class="col-sm-6 mb-3">
                                <div class="col-sm-12">
                                    <div class="col-lg-12 d-none d-lg-block">
                                        <div class="card">
                                            <div class="card-header text-bold text-center text-muted">
                                                Imagen de perfil <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <img id="user_image_preview_update_{{ $user->id }}" src="{{ Storage::url('images/uploads/' . $user->image) }}"
                                                        style="object-fit: contain;" class="rounded" width="185" height="185">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <div class="form-floating">
                                        <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('address') is-invalid @enderror" id="address_{{ $user->id }}" name="address"
                                            style="resize: none; height: 100px; font-size: clamp(0.7rem, 3vh, 0.8rem);" minlength="5" maxlength="255">{{ $user->address }}</textarea>
                                        <label for="address" class="form-label">Dirección</label>
                                    </div>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror"
                                        id="image_{{ $user->id }}" name="image" onchange="show_user_image_update(event, {{ $user->id }})">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <p><strong>{{ $message }}<a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen"> Es necesario optimizar la imagen del usuario.</strong></a></p>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Size error modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content border-danger-double">
                                        <div class="modal-header bg-danger-dark" style="color: white;">
                                            <p class="modal-title" id="exampleModalLabel">Advertencia</p>
                                        </div>
                                        <div class="modal-body">
                                            El tamaño máximo permitido para las imágenes de productos es 8 MB. Intente <a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen">optimizar la imagen</a>
                                            o cambiar la imagen del producto a una con menor peso.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <a data-dismiss="modal" class="btn btn-sm btn-dark">
                                        Regresar
                                    </a>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Registrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User update preview -->
<script src="{{ asset('customjs/image_previews/user_update.js') }}"></script>